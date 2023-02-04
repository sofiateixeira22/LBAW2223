# EAP: Architecture Specification and Prototype
> For everyone from all generations that needs help to find the solution to their problem, Queryly is a web-based system that allows you to post all your questions that need an answer, and/or post answers to help other users find the way to the solution of their problem. Unlike other services, our product is a safe space for all users no matter race, gender, sexuality, or age. Queryly is designed to be a helpful system for anyone that decides to join our community.

## A7: Web Resources Specification

> A specification is a written description of the features or characteristics that a product must have before being delivered. It lists the resources that are available, their properties, and the JSON response format.

### 1. Overview

| Modules                     | Description |
| --------------------------- | ----------- |
| M01: Authentication         | Web resources associated with authentication. It includes the following system features: sign in, sign out and registration. |
| M02: Individual Profile     | Web resources associated with individual profile management. It includes the following system features: view user profile. |
| M03: Posts                  | Web resources associated with individual posts management. It includes the following system features: view post.|

### 2. Permissions

|     |                            |
| --- | -------------------------- |
| PUB | Public                     |
| USR | Authenticated User         |
| OWR | Owner of the post/account  |
| ADM | Administrator              |

### 3. OpenAPI Specification

This section contains the OpenAPI Specification used for this project.
It can be found [here](https://git.fe.up.pt/lbaw/lbaw2223/lbaw2294/-/blob/dev/a7_openapi.yml?plain=0)


```yaml
openapi: 3.0.0

info:
 version: '1.0'
 title: 'Queryly Web API'
 description: 'Web Resources Specification (A7) for Queryly'

servers:
- url: http://lbaw2294.lbaw.fe.up.pt/
  description: Production server

externalDocs:
 description: Find more info here.
 url: https://git.fe.up.pt/lbaw/lbaw2223/lbaw2294/-/wikis/home

tags:
 - name: 'M01: Authentication'
 - name: 'M02: Individual Profile'
 - name: 'M03: Posts'
 - name: 'M04: Comments'
 - name: 'M05: User Administration'
 - name: 'M06: Post Administration'
 - name: 'M07: Comment Administration'
 - name: 'M08: Static Pages'

paths:
 /login:
   get:
     operationId: R101
     summary: 'R101: Login Form'
     description: 'Provide login form. Access: PUB'
     tags:
       - 'M01: Authentication'
     responses:
       '200':
         description: 'Ok. Show Log-in UI'
   post:
     operationId: R102
     summary: 'R102: Login Action'
     description: 'Processes the login form submission. Access: PUB'
     tags:
       - 'M01: Authentication'

     requestBody:
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               email:          # <!--- form field name
                 type: string
               password:    # <!--- form field name
                 type: string
             required:
                  - email
                  - password

     responses:
       '302':
         description: 'Redirect after processing the login credentials.'
         headers:
           Location:
             schema:
               type: string
             examples:
               302Success:
                 description: 'Successful authentication. Redirect to user profile.'
                 value: '/users/{id}'
               302Error:
                 description: 'Failed authentication. Redirect to login form.'
                 value: '/login'

 /logout:

   post:
     operationId: R103
     summary: 'R103: Logout Action'
     description: 'Logout the current authenticated user. Access: USR, ADM'
     tags:
       - 'M01: Authentication'
     responses:
       '302':
         description: 'Redirect after processing logout.'
         headers:
           Location:
             schema:
               type: string
             examples:
               302Success:
                 description: 'Successful logout. Redirect to login form.'
                 value: '/'

 /register:
   get:
     operationId: R104
     summary: 'R104: Register Form'
     description: 'Provide new user registration form. Access: PUB'
     tags:
       - 'M01: Authentication'
     responses:
       '200':
         description: 'Ok. Show Sign-Up UI'

   post:
     operationId: R105
     summary: 'R105: Register Action'
     description: 'Processes the new user registration form submission. Access: PUB'
     tags:
       - 'M01: Authentication'

     requestBody:
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               name:
                 type: string
               email:
                 type: string
               username:
                 type: string
               password:
                 type: string
               birthday:
                 type: string
                 format: date
                 description: 'Birthday of user'
                 example: '30-01-2022'
             required:
                - name
                - email
                - username
                - password
                - birthday

     responses:
       '302':
         description: 'Redirect after processing the new user information.'
         headers:
           Location:
             schema:
               type: string
             examples:
               302Success:
                 description: 'Successful authentication. Redirect to user profile.'
                 value: '/users/{id}'
               302Failure:
                 description: 'Failed authentication. Redirect to login form.'
                 value: '/register'

 /users/{id}:
   get:
     operationId: R201
     summary: 'R201: View user profile'
     description: 'Show the individual user profile. Access: PUB'
     tags:
       - 'M02: Individual Profile'

     parameters:
       - in: path
         name: id
         schema:
           type: integer
         required: true

     responses:
       '200':
         description: 'Ok. Show User Profile UI'

 /users/{id}/edit:
   get:
     operationId: R202
     summary: 'R202: Show edit user form'
     description: 'Show the individual user profile editing page. Access: OWR'
     tags:
       - 'M02: Individual Profile'

     parameters:
       - in: path
         name: id
         schema:
           type: integer
         required: true

     responses:
       '200':
         description: 'Ok. Show User Profile Edit UI'
   patch:
    operationId: R203
    summary: 'R203: Process show edit user form'
    description: 'Process the individual user profile editing information. Access: OWR'
    tags:
      - 'M02: Individual Profile'
    parameters:
       - in: path
         name: id
         schema:
           type: integer
         required: true
    responses:
      '302':
        description: 'Redirect after processing the edit information back to the user page.'
        headers:
          Location:
            schema:
              type: string

 /users/{id}/questions:
   get:
     operationId: R204
     summary: 'R204: View user own questions'
     description: 'Show the individual user questions. Access: PUB'
     tags:
       - 'M02: Individual Profile'

     parameters:
       - in: path
         name: id
         schema:
           type: integer
         required: true

     responses:
       '200':
         description: 'Ok. Show User Questions UI'
         
 /users/{id}/answers:
   get:
     operationId: R205
     summary: 'R205: View user own answers'
     description: 'Show the individual user answers. Access: PUB'
     tags:
       - 'M02: Individual Profile'

     parameters:
       - in: path
         name: id
         schema:
           type: integer
         required: true

     responses:
       '200':
         description: 'Ok. Show User Answers UI'

 /api/users/{id}:
  delete:
    operationId: R206
    summary: 'R206: Delete User Account'
    description: 'Delete the account. Access: USR, ADM'
    tags:
      - 'M02: Individual Profile'
    parameters:
      - in: path
        name: id
        schema:
          type: integer
        required: true
    responses:
      '302':
        description: 'Ok. Show login UI'
         
 /posts/{id}:
   get:
     operationId: R301
     summary: 'R301: View post'
     description: 'Show the post. Access: PUB'
     tags:
       - 'M03: Posts'

     parameters:
       - in: path
         name: id
         schema:
           type: integer
         required: true

     responses:
       '200':
         description: 'Ok. Show Post UI'
  
 /posts/questions/new:
   get:
    operationId: R302
    summary: 'R302: Add Question Form'
    description: 'Provide new question form. Access: USR'
    tags:
      - 'M03: Posts'

    parameters:
      - in: path
        name: userId
        schema:
          type: integer
        required: true
    
    responses:
       '200':
         description: 'Ok. Show Add Question UI'
    
   post:
    operationId: R303
    summary: 'R303: Add Question Action'
    description: 'Processes the new question form submission. Access: USR'
    tags:
      - 'M03: Posts'

    requestBody:
      required: true
      content:
        application/x-www-form-urlencoded:
          schema:
            type: object
            properties:
              title:
                type: string
              postText:
                type: string
            required:
               - title
               - postText

    responses:
      '302':
        description: 'Redirect after processing the new question information.'
        headers:
          Location:
            schema:
              type: string

 /posts/answers/new:
   get:
    operationId: R304
    summary: 'R304: Add Answer Form'
    description: 'Provide new answer form. Access: USR'
    tags:
      - 'M03: Posts'

    parameters:
      - in: path
        name: userId
        schema:
          type: integer
        required: true
      - in: path
        name: postId
        schema:
          type: integer
        required: true
    
    responses:
       '200':
         description: 'Ok. Show Add Answer UI'
    
   post:
    operationId: R305
    summary: 'R305: Add Answer Action'
    description: 'Processes the new answer form submission. Access: USR'
    tags:
      - 'M03: Posts'

    requestBody:
      required: true
      content:
        application/x-www-form-urlencoded:
          schema:
            type: object
            properties:
              postText:
                type: string
            required:
               - postText

    responses:
      '302':
        description: 'Redirect after processing the new answer information.'
        headers:
          Location:
            schema:
              type: string
 
 /posts/{id}/edit:
   get:
    operationId: R306
    summary: 'R306: Edit Post Form'
    description: 'Provide edit post form. Access: OWR'
    tags:
      - 'M03: Posts'

    parameters:
      - in: query
        name: title
        schema:
          type: integer
        required: false
      - in: query
        name: postText
        schema:
          type: integer
        required: false
    
    responses:
       '200':
         description: 'Ok. Show Edit Post UI'

   patch:
    operationId: R307
    summary: 'R307: Edit Post Action'
    description: 'Provide edit post form. Access: OWR'
    tags:
      - 'M03: Posts'
    
    parameters:
      - in: query
        name: postText
        schema:
          type: integer
        required: false
    
    responses:
      '302':
        description: 'Redirect after processing edit post information.'
        headers:
          Location:
            schema:
              type: string


 /homepage:
  get:
    operationId: R308
    summary: 'R308: Show homepage'
    description: 'Show all posts indiscriminately. Access: PUB'
    tags:
      - 'M03: Posts'
    responses:
       '200':
         description: 'Ok. Show HomePage UI'
  post:
    operationId: R309
    summary: 'R309: Show search results'
    description: 'Processes the search and displays the results. Access: PUB'
    tags:
      - 'M03: Posts'
    requestBody:
      required: true
      content:
        application/x-www-form-urlencoded:
          schema:
            type: object
            properties:
              search:
                type: string
              tags:
                type: string
              searchfor:
                type: string
              orderby:
                type: string
            required:
               - searchfor
               - orderby
    responses:
      '302':
        description: 'Redirect after processing the search.'
        headers:
          Location:
            schema:
              type: string
              
 /api/posts/{id}:
   delete:
     operationId: R310
     summary: 'R310: Delete a post API'
     description: 'Delete a post. Access: OWR, ADM'
     tags:
       - 'M03: Posts'

     parameters:
       - in: path
         name: userId
         schema:
           type: integer
         required: true
       - in: path
         name: postId
         schema:
           type: integer
         required: true
         
     responses:
       '302':
         description: 'Ok. Show Post UI'

 /api/star/{userId}/{postId}:
   get:
     operationId: R311
     summary: 'R311: Show star'
     description: 'Show if star is active in a post. Access: USR'
     tags:
       - 'M03: Posts'

     parameters:
       - in: path
         name: userId
         schema:
           type: integer
         required: true
       - in: path
         name: postId
         schema:
           type: integer
         required: true
     
     responses:
       '200':
         description: 'Ok. Show Post UI'
         
   put:
     operationId: R312
     summary: 'R312: Like a post API'
     description: 'Put a star in a post. Access: USR'
     tags:
       - 'M03: Posts'

     parameters:
       - in: path
         name: userId
         schema:
           type: integer
         required: true
       - in: path
         name: postId
         schema:
           type: integer
         required: true
         
     responses:
       '302':
         description: 'Ok. Show Post UI'
         
   delete:
     operationId: R313
     summary: 'R313: Unlike a post API'
     description: 'Delete star in a post. Access: USR'
     tags:
       - 'M03: Posts'

     parameters:
       - in: path
         name: userId
         schema:
           type: integer
         required: true
       - in: path
         name: postId
         schema:
           type: integer
         required: true
         
     responses:
       '302':
         description: 'Ok. Show Post UI'

         
 /comments/{id}:
   get:
     operationId: R401
     summary: 'R401: View comment'
     description: 'Show the comment. Access: PUB'
     tags:
       - 'M04: Comments'

     parameters:
       - in: path
         name: id
         schema:
           type: integer
         required: true

     responses:
       '200':
         description: 'Ok. Show Comment UI'
         
 /about:
   get:
     operationId: R801
     summary: 'R801: View about page'
     description: 'Show the about page. Access: PUB'
     tags:
       - 'M08: Static Pages'
       
     responses:
       '200':
         description: 'Ok. Show About UI'

 /contacts:
   get:
     operationId: R802
     summary: 'R802: View contacts page'
     description: 'Show the contacts page. Access: PUB'
     tags:
       - 'M08: Static Pages'
       
     responses:
       '200':
         description: 'Ok. Show Contacts UI'
  
 /faq:
   get:
     operationId: R803
     summary: 'R803: View faqs page'
     description: 'Show the faqs page. Access: PUB'
     tags:
       - 'M08: Static Pages'
       
     responses:
       '200':
         description: 'Ok. Show FAQs UI'
  
```

---


## A8: Vertical prototype

> A vertical prototype is the back end of a product like a database generation to test front end. It used to improve database design, test key components at early stages or showcase a working model, though unfinished, to check the key functions.

### 1. Implemented Features

#### 1.1. Implemented User Stories

The user stories with high priority that have been implemented in the vertical prototype are present in this section. 

| User Story reference | Name                   | Priority                   | Description                   |
| -------------------- | ---------------------- | -------------------------- | ----------------------------- |
| US01 | View Top Questions | high | **As a** *User*, <br> **I want to** view the top questions of the website, <br> **so that** I can see the content that other users interact with more. |
| US02 | Browse Questions | high | **As a** *User*, <br> **I want to** browse questions, <br> **so that** I can browse for questions that I’m more interested in. |
| US03 | Exact Match Search | high | **As a** *User*, <br> **I want to** type in something on the search bar, <br> **so that** the search result matches the precise keywords in the prescribed order. |
| US04 | Full-text Search | high | **As a** *User*, <br> **I want to** to type in something on the search bar, <br> **so that** the search results contain at least one match to the search parameters. |
| US16 | Sign in | high | **As a** *Visitor*, <br> **I want to** authenticate into the system, <br> **so that** I can access privileged information.
| US17 | Sign up | high | **As a** *Visitor*, <br> **I want to** register myself into the system, <br> **so that** I can authenticate myself into the system. |
| US19 | Log out | high | **As an** *Author*, <br> **I want to** terminate my authentication to the system, <br> **so that** no one has access to my account on that machine. |
| US20 | View Own Profile | high | **As an** *Author*, <br> **I want to** view my own profile, <br> **so that** I can see my personal information. |
| US21 | Edit Own Profile | high | **As an** *Author*, <br> **I want to** edit my own profile, <br> **so that** I can update my personal information. |
| US22 | View Personal Feed | high | **As an** *Author*, <br> **I want to** view a personal feed, <br> **so that** I see content on my feed that I’m interested in. |
| US23 | Post Question | high | **As an** *Author*, <br> **I want to** post a question, <br> **so that** another user can help me find the solution. |
| US24 | Post Answer | high | **As an** *Author*, <br> **I want to** post an answer, <br> **so that** I can help another user find the solution to their question. |
| US25 | View My Questions | high | **As an** *Author*, <br> **I want to** view my questions, <br> **so that** I can see all the questions that I made and access them more easily. |
| US26 | View My Answers | high | **As an** *Author*, <br> **I want to** view my answers, <br> **so that** I can see all the answers that I gave and access them more easily. |
| US27 | Edit My Question | high | **As an** *Author*, <br> **I want to** edit my question, <br> **so that** I can add/update/remove content of the question. |
| US28 | Delete My Question | high | **As an** *Author*, <br> **I want to** delete my question, <br> **so that** I can remove my question from the website. |
| US29 | Edit My Answer | high | **As an** *Author*, <br> **I want to** edit my answer, <br> **so that** I can add/update/remove content of the answer. |
| US30 | Delete My Answer | high | **As an** *Author*, <br> **I want to** delete my answer, <br> **so that** I can remove my answer from the website. |
| US51 | Administrate User Accounts | high | **As an** *Administrator*, <br> **I want to** administrate user accounts, <br> **so that** I have the highest level of access to make changes in an account. |

#### 1.2. Implemented Web Resources

The web resources that have been implemented in the vertical prototype are present in this section.


##### **M01: Authentication**

| Web Resource Reference | URL                                                      |
| ---------------------- | -------------------------------------------------------- |
| R101: Login Form       | GET [/login](https://lbaw2294.lbaw.fe.up.pt/login)       |
| R102: Login Action     | POST ```/login```                                        |
| R103: Logout Action    | POST ```/logout```                                       |
| R104: Register Form    | GET [/register](https://lbaw2294.lbaw.fe.up.pt/register) |
| R105: Register Action  | POST ```/register```                                     |

 
##### **M02: Individual Profile** 

| Web Resource Reference   | URL                            |
| ------------------------ | ------------------------------ |
| R201: User Profile       | GET [/users/{id}](https://lbaw2294.lbaw.fe.up.pt/users/13) |
| R202: User Edit Form     | GET [/users/{id}/edit](https://lbaw2294.lbaw.fe.up.pt/users/13/edit) |
| R203: User Edit Action   | PATCH ```/users/{id}/edit``` |
| R204: View Own Questions | GET [/users/{id}/questions](https://lbaw2294.lbaw.fe.up.pt/users/13/questions) |
| R205: View Own Answers   | GET [/users/{id}/answers](https://lbaw2294.lbaw.fe.up.pt/users/13/answers) |
| R206: Delete User        | DELETE ```api/users/{id}``` |

##### **M03: Posts**

| Web Resource Reference    | URL                            |
| ------------------------- | ------------------------------ |
| R301: View Post           | GET [/posts/{id}](https://lbaw2294.lbaw.fe.up.pt/posts/1) |
| R302: Add Question Form   | GET [/posts/questions/new](https://lbaw2294.lbaw.fe.up.pt/posts/questions/new) |
| R303: Add Question Action | POST ```/posts/questions/new``` |
| R304: Add Answer Form     | GET [/posts/answers/new](https://lbaw2294.lbaw.fe.up.pt/posts/answers/new?question=1) |
| R305: Add Answer Action   | POST ```/posts/answers/new``` |
| R306: Edit Post Form      | GET [/posts/{id}/edit](https://lbaw2294.lbaw.fe.up.pt/posts/23/edit) |
| R307: Edit Post Action    | PATCH ```/posts/{id}/edit``` |
| R308: Homepage            | GET [/homepage](https://lbaw2294.lbaw.fe.up.pt/homepage) |
| R309: Search Results      | POST ```/homepage``` |
| R310: Delete Post         | DELETE ```api/posts/{id}``` |

### 2. Prototype

| Role | Email | Password |
| ---- | ----- | -------- |
| Administrator | admin@example.com | 1234 |

Although the account above is the only one that can be accessed by the login form, there are dummy accounts to populate the website and to test features, such as permissions. To test all features with a normal user account, we can use the register form to create a new account that we can login into.
An example of a user that can be created:

| Name | Username    | Birthday   | Email         | Password |
| ---- | ----------- | ---------- | ------------- | -------- |
| Test | testingUser | 01/01/2000 | test@test.com | 123456   |

To be able to test our prototype, you can click [here](https://lbaw2294.lbaw.fe.up.pt).
And to access the source code of the project, you can click [here](https://git.fe.up.pt/lbaw/lbaw2223/lbaw2294).


---

## Revision history
Since this is the first submission, there are no changes to be listed in this section.

---

GROUP2294 22/11/2022

- Ana Sofia Teixeira, [up201906031@fc.up.pt](mailto:up201906031@fc.up.pt) (editor)
- Gabriel Alves, [up201709532@fc.up.pt](mailto:up201709532@fc.up.pt)
- Guilherme Bica, [up201705374@fc.up.pt](mailto:up201705374@fc.up.pt)
- Margarida Nazaré, [up201908209@fc.up.pt](mailto:up201908209@fc.up.pt)