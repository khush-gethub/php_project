
```mermaid
activityDiagram
    title User Login

    start
    :Navigate to Login Page;
    :Enter Email and Password;
    :Submit Form;
    if (Credentials Valid?) then (yes)
        :Create Session;
        :Redirect to Homepage;
    else (no)
        :Show Error Message;
    endif
    stop
```
