from django.db import models
from django.utils import timezone
from django.contrib.auth.models import User
from PIL import Image
# Create your models here.

class Profile(models.Model):
    user = models.OneToOneField(User, on_delete=models.CASCADE)
    image = models.ImageField(default='default.jpg', upload_to='profile_pics')
    rank = models.PositiveIntegerField(default='0')
    wins = models.PositiveIntegerField(default='0')
    loses = models.PositiveIntegerField(default='0')

    def __str__(self):
        return f'{self.user.username} Profile'

    def save(self, *args, **kwargs):
        super(Profile, self).save(*args, **kwargs)

        image = Image.open(self.image.path)

        if image.height > 300 or image.width > 300:
            output_size = (300, 300)
            image.thumbnail(output_size)
            image.save(self.image.path)

    def AddWinMatch(self):
        self.wins = self.wins + 1
        self.save()
    
    def AddLoseMatch(self):
        self.loses = self.loses + 1
        self.save()