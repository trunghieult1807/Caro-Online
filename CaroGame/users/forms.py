from django import forms
from django.contrib.auth.forms import UserCreationForm, AuthenticationForm
from django.contrib.auth.models import User
from django.contrib.auth import login, authenticate
<<<<<<< HEAD
from .models import Profile
=======
>>>>>>> f46710c57e80d885c78287a3f54b0613026efe47

class RegistrationForm(UserCreationForm):
    email = forms.EmailField()

    class Meta:
        model = User
        fields = ['username', 'email', 'password1', 'password2']

    def __init__(self, *args, **kwargs):
        super(UserCreationForm, self).__init__(*args, **kwargs)

        for fieldname in ['username', 'email', 'password1', 'password2']:
            self.fields[fieldname].help_text = None

        self.fields['username'].widget.attrs.update({'class':'input100', 'placeholder':'Username'})
        self.fields['email'].widget.attrs.update({'class':"input100", 'placeholder':"Email"})
        self.fields['password1'].widget.attrs.update({'class':'input100', 'placeholder':'Password'})
        self.fields['password2'].widget.attrs.update({'class':"input100", 'placeholder':"Confirm Password"})


class LoginForm(AuthenticationForm):
    class Meta:
        model = User
        fields = ['username', 'password']

    def __init__(self, *args, **kwargs):
        super(AuthenticationForm, self).__init__(*args, **kwargs)

        for fieldname in ['username', 'password']:
            self.fields[fieldname].help_text = None
        # self.fields['username'].widget = forms.TextInput(attrs={'class': 'input100', 'placeholder': 'Username'})
        # self.fields['username'].label = False
        self.fields['username'].widget.attrs.update({'class':'input100', 'placeholder':'Username'})
        self.fields['password'].widget.attrs.update({'class':"input100", 'placeholder':"Password"})

    def clean(self):
        username = self.cleaned_data.get('username')
        password = self.cleaned_data.get('password')
        user = authenticate(username=username, password=password)
        if not user or not user.is_active:
            raise forms.ValidationError("Wrong username or password. Please try again.")
<<<<<<< HEAD
        return self.cleaned_data

class UserUpdateForm(forms.ModelForm):
    email = forms.EmailField()

    class Meta:
        model = User
        fields = ['email']

class ProfileUpdateForm(forms.ModelForm):
    class Meta:
        model = Profile
        fields = ['image']
=======
        return self.cleaned_data
>>>>>>> f46710c57e80d885c78287a3f54b0613026efe47
