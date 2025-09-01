
```mermaid
usecaseDiagram
    actor User
    actor Admin

    Admin --|> User

    rectangle "Social Media System" {
        User -- (Register)
        User -- (Login)
        User -- (Logout)
        User -- (Create Post)
        User -- (View Posts)
        User -- (React to Post)
        User -- (Edit Profile)
        User -- (Delete Own Post)
        User -- (Edit Own Post)

        Admin -- (Ban User)
        Admin -- (Delete any Post)
        Admin -- (Edit any Post)
        Admin -- (View Dashboard)
    }
```
