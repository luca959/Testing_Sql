#!/usr/bin/env python3
#output : X attacco passato|  V attacco fallito
#Ferrati Luca - Simone Aquilini - Mirco Vella
import pytest
import requests
WHOAMI_ORACLE = "root@172.17.0.1" #sql version

@pytest.mark.parametrize("pages", ["find.php","find2.php","find3.php","search.php"])
@pytest.mark.parametrize("Inj",["'UNION ALL SELECT USER(),2 -- -"," 1 OR 1=1 UNION ALL SELECT USER(),2 -- -",'"UNION ALL SELECT USER(),2 -- -',
                              "Arthur' AND ExtractValue(0, CONCAT( 0x5c, USER() ) ) -- -",'" AND ExtractValue(0, CONCAT( 0x5c, USER() ) ) -- -'])
def test_search(pages,Inj):
    cookies = { 'a': '1' }
    headers = { }
    params = {
        'search': Inj 
    }
    print("testing "+pages)
    print("testing "+Inj)
    response = requests.get('http://localhost:5000/'+pages, params=params, cookies=cookies, headers=headers)
    assert WHOAMI_ORACLE not in response.text
 
@pytest.mark.parametrize("pages", ["search_by_price.php","search_by_price2.php","search_by_price3.php","search_by_price4.php","search.php"])
@pytest.mark.parametrize("Inj",['1 UNION ALL SELECT USER() as price, USER() as name-- -',"' UNION ALL SELECT USER(),2 -- -",
                                "1 AND ExtractValue(0, CONCAT( 0x5c, USER() ) ) -- -"])
def test_max(pages,Inj):
    cookies = { 'a': '1' }
    headers = { }
    params = {
        'max': Inj 
    }
    print("testing "+pages)
    print("testing "+Inj)
    response = requests.get('http://localhost:5000/'+pages, params=params, cookies=cookies, headers=headers)
    assert WHOAMI_ORACLE not in response.text

@pytest.mark.parametrize("pages", ["login.php","login2.php","login3.php"])
@pytest.mark.parametrize("Inj",[ "' UNION ALL SELECT USER(),2,3,4 -- - ","' AND ExtractValue(0, CONCAT( 0x5c, USER() ) ) -- -"])
def test_login(pages,Inj):
    cookies = { 'a': '1' }
    headers = { }
    params = {
        'user': '',
        'pass': Inj 
    }
    print("testing "+pages)
    print("testing "+Inj)
    response = requests.post('http://localhost:5000/'+pages, data=params, cookies=cookies, headers=headers)
    assert WHOAMI_ORACLE  not in response.text
 


