
# Patient Management API

This API is used to manage patient data. All endpoints are protected by the `accessKey` middleware, requiring an `accessKey` header for authentication.

---

## Authentication

All requests must include an **accessKey** in the header:

```
accessKey: your-api-access-key
```

---

## Endpoints

Base URL:
```
https://yourdomain.com/api
```

### GET /patients

Retrieve all patient data.

**Request:**
```http
GET /patients
Headers:
  accessKey: your-api-access-key
```

**Response:**
```json
{
    "status": "success",
    "data": [
        {
            "id": 1,
            "user_id": "1",
            "name": "Arianda",
            "medium_acquisition": "online",
            "created_at": "2025-05-13T07:24:11.000000Z"
        },
    ]
}
```

---

### GET /patients/{id}

Retrieve patient details by ID.

```http
GET /patients/1
Headers:
  accessKey: your-api-access-key
```

**Response:**
```json
{
    "status": "success",
    "data": {
        "id": 1,
        "user_id": "1",
        "medium_acquisition": "online",
        "created_at": "2025-05-13T07:24:11.000000Z",
        "updated_at": "2025-05-13T07:24:11.000000Z",
        "user_physiomobile": {
            "id": 6,
            "name": "Arianda",
            "id_type": "KTP",
            "id_no": "1234567890123214",
            "gender": "male",
            "dob": "1995-04-21",
            "address": "Jl. Anggrek No. 9, Banda Aceh",
            "created_at": "2025-05-13T07:24:11.000000Z",
            "updated_at": "2025-05-13T07:24:11.000000Z"
        }
    }
}
```

---

### POST /patients

Add a new patient.

```http
POST /patients
Headers:
  accessKey: your-api-access-key
  Content-Type: application/json

Body:
{
  "name": "Arianda",
  "id_type": "KTP",
  "id_no": "1234567890123457",
  "gender": "male",
  "dob": "1995-04-21",
  "address": "Jl. Anggrek No. 10, Banda Aceh",
  "medium_acquisition": "online"
}

```
---

### PUT /patients/{id}

Update patient data by ID.

```http
PUT /patients/1
Headers:
  accessKey: your-api-access-key
  Content-Type: application/json

Body:
{
  "name": "Arianda Updated",
  "id_type": "KTP",
  "id_no": "1234567890123457",
  "gender": "female",
  "dob": "1995-04-21",
  "address": "Jl. Anggrek No. 10, Banda Aceh",
  "medium_acquisition": "offline"
}

```
---

### DELETE /patients/{id}

Delete a patient record.

```http
DELETE /patients/1
Headers:
  accessKey: your-api-access-key
```

**Response:**
```json
{
    "status": "success",
    "message": "Patient deleted successfully"
}
```

---


## Notes

- Make sure to replace `your-api-access-key` with a valid key.
- The `dob` field must follow the `YYYY-MM-DD` format.