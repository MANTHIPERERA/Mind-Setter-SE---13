#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Mon Mar  6 11:49:19 2023

@author: manthiperera
"""

from flask import Flask #Creates flask Application
from views import views
from jinja2 import Environment

def my_enumerate(iterable):
    return enumerate(iterable)

env = Environment()
env.globals.update(enumerate=my_enumerate)

app = Flask(__name__)
app.register_blueprint(views, url_prefix="/")

if __name__ == '__main__':
    app.run(debug=True, port = 8000)
