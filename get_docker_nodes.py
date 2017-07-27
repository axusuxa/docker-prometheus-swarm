#!/usr/bin/python
import docker, json
client = docker.from_env()

nodes = client.nodes.list()
for node in nodes:
    nodeattrs = client.nodes.get(str(node)[7:-1])
    #json.dumps(nodeattrs.attrs)
    print nodeattrs.attrs['ManagerStatus']['Addr']