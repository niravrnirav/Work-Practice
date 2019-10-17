import requests
from bs4 import BeautifulSoup

URL = ''

headers = {
    "User-Agent": 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36'
}

page = requests.get(URL, headers=headers)

soup = BeautifulSoup(page.content, 'html.parser')

mydivs = soup.findAll("div", {"class": "custom-field__value ng-binding ng-scope"})

print(soup.prettify())

    a
    a