from flask import Flask, render_template

app = Flask(__name__)

@app.route("/")
def caro():
    return render_template("caro.html")
