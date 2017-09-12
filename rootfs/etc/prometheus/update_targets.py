#!/usr/bin/python3
import urllib.request, json

def ordered(obj):
    if isinstance(obj, dict):
        return sorted((k, ordered(v)) for k, v in obj.items())
    if isinstance(obj, list):
        return sorted(ordered(x) for x in obj)
    else:
        return obj

configfile = '/etc/prometheus/targets.json'
with open(configfile) as target_file:
    try:
        target = json.load(target_file)
    except:
        target = json.loads('{}')

try:
    with urllib.request.urlopen("http://i-apiact1.pbe.sanookonline.net:8000") as url:
        update_target = json.loads(url.read().decode())
except:
    update_target = target

if ordered(target) == ordered(update_target):
    print("Already up-to-date.")
else:
    with open(configfile, 'w') as target_file:
        json.dump(update_target, target_file)
    print("Config file updated")
