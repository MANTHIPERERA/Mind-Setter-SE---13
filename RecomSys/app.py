#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Mon Mar  6 11:49:19 2023

@author: manthiperera
"""

from flask import Flask #Creates flask Application
from views import views

app = Flask(__name__)
app.register_blueprint(views, url_prefix="/")

if __name__ == '__main__':
    app.run(debug=True, port = 8000)
