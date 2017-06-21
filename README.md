Startup
===
1. make
2. make startup

Test
===
curl -X POST -H 'Authorization: Basic YXBpOmRhdGFzcHJpbmc=' -H 'Content-Type: application/json' -d '{"user": {"name": "Guobin", "age": 10}}' -i http://localhost:8000/api/v1/users

curl -X POST -H 'Authorization: Basic YXBpOmRhdGFzcHJpbmc=' -H 'Content-Type: application/json' -d '{"user": {"name": "Guobin", "age": 101}}' -i http://localhost:8000/api/v1/users

