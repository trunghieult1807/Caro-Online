from django.contrib import admin
from .models import *

# Register your models here.

admin.site.register(Room)
admin.site.register(Game)
admin.site.register(GameCell)
admin.site.register(GameLog)
