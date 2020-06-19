from django.http import HttpResponse
from django.shortcuts import render

# Create your views here.

# Main page
def index(request):
    return render(request, "caro/index.html")
