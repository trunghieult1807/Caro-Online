from django import forms
from django.contrib.auth.forms import UserCreationForm, AuthenticationForm
from django.contrib.auth.models import User
from django.contrib.auth import login, authenticate
from .models import Profile

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
        return self.cleaned_data

class UserUpdateForm(forms.ModelForm):
    email = forms.EmailField()

    class Meta:
        model = User
        fields = ['email']

    def __init__(self, *args, **kwargs):
        super(forms.ModelForm, self).__init__(*args, **kwargs)

        for fieldname in ['email']:
            self.fields[fieldname].help_text = None
        # self.fields['username'].widget = forms.TextInput(attrs={'class': 'input100', 'placeholder': 'Username'})
        # self.fields['username'].label = False
        self.fields['email'].widget.attrs.update({'class':'input100', 'placeholder':'Email'})

class ProfileUpdateForm(forms.ModelForm):
    class Meta:
        model = Profile
        fields = ['image']

    def __init__(self, *args, **kwargs):
        super(forms.ModelForm, self).__init__(*args, **kwargs)

        for fieldname in ['image']:
            self.fields[fieldname].help_text = None
        # self.fields['username'].widget = forms.TextInput(attrs={'class': 'input100', 'placeholder': 'Username'})
        # self.fields['username'].label = False
        self.fields['image'].widget.attrs.update({'style':'display:none'})
