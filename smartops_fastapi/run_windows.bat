@echo off
setlocal
cd /d "%~dp0"
if not exist .env (
  >.env echo DB_HOST=127.0.0.1
  >>.env echo DB_PORT=3306
  >>.env echo DB_USER=root
  >>.env echo DB_PASSWORD=
  >>.env echo DB_NAME=smartstay_php
  >>.env echo DB_UNIX_SOCKET=
  >>.env echo JSONL_PATH=../data/whole_pipeline_results.jsonl
)
if not exist .venv py -3.12 -m venv .venv
call .venv\Scripts\activate.bat
python -m pip install --disable-pip-version-check -q -r requirements.txt
python -m uvicorn main:app --host 127.0.0.1 --port 8001
endlocal
