
```mermaid
activityDiagram
    title User Registration

    start
    :Navigate to Register Page;
    :Fill out Registration Form;
    :Submit Form;
    if (Input Valid?) then (yes)
        :Create User in Database;
        :Redirect to Login Page;
    else (no)
        :Show Error Message;
    endif
    stop
```
