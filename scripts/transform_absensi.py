#!/usr/bin/env python3
"""Transform attendance files into per-sangga / sub-sangga / gender outputs.

Usage examples:
  python scripts/transform_absensi.py --input "storage/app/Data Kelas X Tahun 2026/ABSENSI PI.csv" --role PI --output out
  python scripts/transform_absensi.py --input Absensi_PA.xlsx --mapping Absensi_PA.xlsx --role PA --output out

The script attempts to:
- Parse CSVs that have section headers like 'PENEGAS 1 PI' and semicolon-delimited rows.
- Optionally merge with mapping Excel files that contain columns: "Nama Lengkap","Sangga","SubSangga","Gender".
- Produce an aggregated Excel with columns: Name,Class,Sangga,SubSangga,Gender,Source
- Produce separate files for putra (male) and putri (female).
"""
from __future__ import annotations
import argparse
import os
import re
import pandas as pd
from typing import List, Dict


def normalize_name(n: str) -> str:
    return re.sub(r"\s+", " ", (n or "").strip()).lower()


def parse_semicolon_csv(path: str) -> pd.DataFrame:
    rows = []
    current_sangga = None
    with open(path, encoding="utf-8", errors="replace") as f:
        for raw in f:
            line = raw.strip('\n\r')
            if not line:
                continue
            # detect section header like: PENEGAS 1 PI;;;;;;;;;;;;;;;
            if line.upper().startswith("PENEGAS") or line.upper().startswith("SANGGA"):
                # extract readable sangga name
                current_sangga = line.split(';')[0].strip()
                continue
            parts = line.split(';')
            # typical data row starts with a number in first column
            if parts and re.match(r"^\d+$", parts[0].strip()):
                name = parts[1].strip() if len(parts) > 1 else ""
                kelas = parts[2].strip() if len(parts) > 2 else ""
                rows.append({"Nama Lengkap": name, "Kelas": kelas, "Sangga": current_sangga, "Source": os.path.basename(path)})
    return pd.DataFrame(rows)


def load_mapping(path: str) -> pd.DataFrame:
    df = pd.read_excel(path)
    # Normalize expected column names
    expected = [c for c in df.columns]
    # try to find name-like column
    name_col = None
    for c in expected:
        if 'nama' in c.lower():
            name_col = c
            break
    if name_col is None:
        raise SystemExit(f"Mapping file {path} has no name-like column; found: {expected}")
    df = df.rename(columns={name_col: 'Nama Lengkap'})
    # optional columns mapping
    for c in df.columns:
        if 'sangga' in c.lower() and c != 'Sangga':
            df = df.rename(columns={c: 'Sangga'})
        if 'sub' in c.lower() and 'sangga' in c.lower() and c != 'SubSangga':
            df = df.rename(columns={c: 'SubSangga'})
        if 'jenis' in c.lower() or 'gender' in c.lower() or 'kelamin' in c.lower():
            df = df.rename(columns={c: 'Gender'})
    return df


def merge_mapping(base: pd.DataFrame, mapping: pd.DataFrame) -> pd.DataFrame:
    mapping = mapping.copy()
    mapping['__n'] = mapping['Nama Lengkap'].astype(str).apply(normalize_name)
    base['__n'] = base['Nama Lengkap'].astype(str).apply(normalize_name)
    merged = base.merge(mapping[['__n','Sangga','SubSangga','Gender']], on='__n', how='left')
    # prefer mapped Sangga/SubSangga/Gender when present
    for col in ['Sangga','SubSangga','Gender']:
        if col not in merged.columns:
            merged[col] = None
    merged = merged.drop(columns=['__n'])
    return merged


def ensure_gender(df: pd.DataFrame, role: str) -> pd.DataFrame:
    df = df.copy()
    if 'Gender' not in df.columns:
        df['Gender'] = None
    df['Gender'] = df['Gender'].fillna('Putri' if role.upper().startswith('PI') else 'Putra')
    # normalize values
    df['Gender'] = df['Gender'].astype(str).apply(lambda v: 'Putra' if v.lower().startswith('p') and 'putri' not in v.lower() else ('Putri' if 'putri' in v.lower() or v.lower().startswith('p') and 'putra' not in v.lower() else v))
    return df


def main():
    p = argparse.ArgumentParser(description="Transform attendance into sangga/sub-sangga/gender outputs")
    p.add_argument('--input', required=True, help='Input file (CSV semicolon or Excel)')
    p.add_argument('--mapping', required=False, help='Optional mapping Excel file (contains Sangga/SubSangga/Gender)')
    p.add_argument('--role', choices=['PA','PI'], required=False, help='Role hint: PA for putra, PI for putri')
    p.add_argument('--output', default='out', help='Output directory')
    args = p.parse_args()

    os.makedirs(args.output, exist_ok=True)

    if args.input.lower().endswith('.csv'):
        base = parse_semicolon_csv(args.input)
    else:
        # try reading as excel with first sheet
        try:
            base = pd.read_excel(args.input)
            # try to standardize columns
            cols = [c.lower() for c in base.columns]
            if 'nama' in ''.join(cols):
                # rename heuristically
                for c in base.columns:
                    if 'nama' in c.lower():
                        base = base.rename(columns={c: 'Nama Lengkap'})
                    if 'kelas' in c.lower():
                        base = base.rename(columns={c: 'Kelas'})
            base['Source'] = os.path.basename(args.input)
        except Exception as e:
            raise SystemExit(f"Unable to read input {args.input}: {e}")

    mapped = base
    if args.mapping:
        mapping = load_mapping(args.mapping)
        mapped = merge_mapping(base, mapping)

    mapped = ensure_gender(mapped, args.role or '')

    out_all = os.path.join(args.output, 'all_transformed.xlsx')
    out_putra = os.path.join(args.output, 'putra.xlsx')
    out_putri = os.path.join(args.output, 'putri.xlsx')

    # reorder and fill missing
    cols = ['Nama Lengkap','Kelas','Sangga','SubSangga','Gender','Source']
    for c in cols:
        if c not in mapped.columns:
            mapped[c] = None
    mapped = mapped[cols]

    mapped.to_excel(out_all, index=False)
    mapped[mapped['Gender'].str.contains('Putra', na=False)].to_excel(out_putra, index=False)
    mapped[mapped['Gender'].str.contains('Putri', na=False)].to_excel(out_putri, index=False)

    print(f"Wrote: {out_all}")
    print(f"Wrote: {out_putra}")
    print(f"Wrote: {out_putri}")
    print(mapped.groupby(['Sangga','SubSangga','Gender']).size().sort_values(ascending=False))


if __name__ == '__main__':
    main()
