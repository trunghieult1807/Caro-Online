# Generated by Django 3.0.7 on 2020-07-19 09:28

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('caro', '0001_initial'),
    ]

    operations = [
        migrations.AddField(
            model_name='room',
            name='user1_ready',
            field=models.BooleanField(default=False),
        ),
        migrations.AddField(
            model_name='room',
            name='user2_ready',
            field=models.BooleanField(default=False),
        ),
    ]
