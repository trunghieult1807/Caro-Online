from flask import Flask, render_template
# from flask_socketio import SocketIO, send
from caro import *

app = Flask(__name__)
app.config['SECRET_KEY'] = 'testsocket'
# socketio = SocketIO(app)


caro = Caro()

@app.route('/')
def index():
    board_size = caro.get_board_size()

    return render_template('index.html')

# @socketio.on('message')
# def handleMessage(msg):
#     print('Message: ' + msg)
#     send(msg, broadcast=True)



if __name__ == '__main__':
    # socketio.run(app)
    app.run(debug=True)
