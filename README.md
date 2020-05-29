### Run

```
make
make startup
curl -X POST -H 'Authorization: Basic YXBpOmRhdGFzcHJpbmc=' \
-H 'Content-Type: application/json' \
-d '{"user": {"name": "Guobin", "age": 10}}' \
-i http://localhost:8000/api/v1/users
```
