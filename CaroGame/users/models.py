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

    def add_win_match(self):
        self.wins = self.wins + 1
        self.rank = self.rank + 10
        self.save()
    
    def add_lose_match(self):
        self.loses = self.loses + 1
        if self.rank - 5 < 0:
            self.rank = 0
        else:
            self.rank = self.rank - 5
        self.save()