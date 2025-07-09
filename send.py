import requests
import json

def sent_question():
    payload = json.dumps({
        "model": "o4-mini",
        "input": "Write a short articel about AI"
    })
    headers = {
    'Content-Type': 'application/json',
    'Authorization': 'Bearer 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',
    }

    r = requests.request("POST", "https://api.openai.com/v1/responses", headers=headers, data=payload )

    response = json.loads(r.text)
    reply = response["output"][1]["content"][0]["text"]

    return '<br>'.join(reply.split('\n'))