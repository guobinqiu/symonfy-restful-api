Startup
===
1. make
2. make startup

Test
===
Success
curl -X POST -H 'Authorization: Basic YXBpOmRhdGFzcHJpbmc=' -H 'Content-Type: application/json' -d '{"user": {"name": "Guobin", "age": 10}}' -i http://localhost:8000/api/v1/users

Failed
curl -X POST -H 'Authorization: Basic YXBpOmRhdGFzcHJpbmc=' -H 'Content-Type: application/json' -d '{"user": {"name": "Guobin", "age": 101}}' -i http://localhost:8000/api/v1/users

