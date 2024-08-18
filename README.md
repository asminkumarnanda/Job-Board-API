# Job Board API

A simple RESTful API for a job board application using Laravel.

## Features

- User authentication using Laravel Sanctum
- CRUD operations for job listings
- Job applications with many-to-many relationships between users and jobs
- JSON Resources for API responses
- Basic error handling and validation

## Requirements

- PHP >= 8.2
- Composer
- MySQL
- Laravel 11.x

## Setup Instructions

1. **Clone the repository:**

   ```bash
   git clone https://github.com/yourusername/job-board-api.git
   cd job-board-api
2. **Install dependencies:**
   ```bash
     composer update

3. **Copy the .env file and configure it:**   
   ```bash
    cp .env.example .env
   ```
    Update the .env file with your database and other configurations:
   * DB_CONNECTION=mysql
   * DB_HOST=127.0.0.1
   * DB_PORT=3306
   * DB_DATABASE=job_board
   * DB_USERNAME=root
   * DB_PASSWORD=secret
    

4. **Run the database migrations:**  
  ```bash
   php artisan migrate
  ```
5. **Serve the application:**  
  ```bash
   php artisan serve
  ```
## API Endpoints
 #### Base URL -  http://127.0.0.1:8000/api
 ##### 1. Register
##### URL: /register
 ##### method - POST
  ##### Request Body :
   {
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password",
  "password_confirmation": "password"
 }
##### Response:
{
  "success": true,
  "data":[],
  "message": "User registered successfully."
}
 ##### 2. Login
##### URL: /login
 ##### method - POST
  ##### Request Body :
   {
  "email": "john@example.com",
  "password": "password",
 }
##### Response:
{
  "success": true,
  "data": {
    "token": "7|kd2oQEq67mMuN2a3XSJQieQC4RkuOWQ1PZhsa9kxb279e95c",
    "name": "Jhon Doe",
    "user_id": 4
  },
  "message": "User login successfull."
}

 ##### 3. Create Job
##### URL: /jobs
 ##### method - POST
  ##### Request Body :
 headers: {
        "Content-Type": "application/json",
        Authorization: "Bearer " + token,
      }
   {
  "title": "Javascript Developer", (required)
  "description": "Lorem Ipsum", (required)
  "company":"Gtech Solution", (required)
  "location": "Bhubaneswar", (required)
  "salary":50000 (required)
 }
##### Response:
{
  "success": true,
  "data": {
    "id": 4,
    "title": "Python Developer",
    "description": "Lorem Ipsum",
    "company": "Gtech Solution",
    "location": "Bhubaneswar",
    "salary": "50000"
  },
  "message": "Job Created Successfully"
}
 ##### 4.Can Read Jobs Who Has created it. 
##### URL: /jobs
 ##### method - GET
  ##### Request Body :
 headers: {
        "Content-Type": "application/json",
        Authorization: "Bearer " + token,
      }

##### Response:
{
  "success": true,
  "data": [   
    { "id": 4,
    "title": "Python Developer",
    "description": "Lorem Ipsum",
    "company": "Gtech Solution",
    "location": "Bhubaneswar",
    "salary": "50000"
    }
  ],
  "message": "Jobs Retrived Successfully"
}

 ##### 5.Can see specific job details. 
##### URL: /jobs/id
id - pass the job_id
 ##### method - GET
  ##### Request Body :
 headers: {
        "Content-Type": "application/json",
        Authorization: "Bearer " + token,
      }

##### Response:
{
  "success": true,
  "data": {
    "id": 4,
    "title": "Python Developer",
    "description": "Lorem Ipsum",
    "company": "Gtech Solution",
    "location": "Bhubaneswar",
    "salary": "50000"
  },
  "message": "Jobs Retrived Successfully"
}
 ##### 6.Can update specific job details. 
##### URL: /jobs/id
id - pass the job_id
 ##### method - PUT 
  ##### Request Body :
 headers: {
        "Content-Type": "application/json",
        Authorization: "Bearer " + token,
      }
 {
    "id": 4,
    "title": "Java Developer",
    // other fields you want to update
  }
##### Response:
{
  "success": true,
  "data": {
    "id": 4,
    "title": "Java Developer",
    "description": "Lorem Ipsum",
    "company": "Gtech Solution",
    "location": "Bhubaneswar",
    "salary": "50000"
  },
  "message": "Job updated successfully"
}
 ##### 7.Can delete specific job details. 
##### URL: /jobs/id
id - pass the job_id
 ##### method - DELETE
  ##### Request Body :
 headers: {
        "Content-Type": "application/json",
        Authorization: "Bearer " + token,
      }
##### Response:
{
  "success": true,
  "message": "Job deleted successfully"
}
 ##### 8.Can Retrive all available jobs . 
##### URL: /get-all-jobs
 ##### method - GET
  ##### Request Body :
 headers: {
        "Content-Type": "application/json",
        Authorization: "Bearer " + token,
      }

##### Response:
{
  "success": true,
  "data": [ 
    {
    "id": 4,
    "title": "Java Developer",
    "description": "Lorem Ipsum",
    "company": "Gtech Solution",
    "location": "Bhubaneswar",
    "salary": "50000"
   }
 ],
  "message": "Job updated successfully"
}
 ##### 9. User can apply a specific job. 
##### URL: /jobs/job/apply
job -pass the job_id
 ##### method - POST
  ##### Request Body :
 headers: {
        "Content-Type": "application/json",
        Authorization: "Bearer " + token,
      }

##### Response:
{
  {
    "success": true,
    "data": [],
    "message": "Application submitted successfully"
 }
}
 ##### 10. Can retrive specific job application. 
##### URL: /jobs/job/applications
job -pass the job_id
 ##### method - GET
  ##### Request Body :
 headers: {
        "Content-Type": "application/json",
        Authorization: "Bearer " + token,
      }

##### Response:
{
    "success": true,
    "data": [
        {
            "id": 2,
            "name": "Rahul",
            "email": "rahul@gmail.com",
            "applied_date": "16-08-2024",
            "applied_time": "11:15:33"
        }
    ],
    "job_details": {
        "id": 4,
        "title": "Python Developer",
        "description": "Lorem Ipsum",
        "company": "Gtech Solution",
        "location": "Bhubaneswar",
        "salary": "50000.00"
    },
    "message": "Job applications retrived successfully"
}
 ##### 11. Can  jobs by location and title. 
##### URL: /jobs-search?title= &location=
job -pass the job_id
 ##### method - GET
  ##### Request Body :
 headers: {
        "Content-Type": "application/json",
        Authorization: "Bearer " + token,
      }

##### Response:
{
    "success": true,
    "data": [
        {
            "id": 3,
            "title": "Javascript Developer",
            "description": "Lorem Ipsum",
            "company": "Gtech Solution",
            "location": "Bhubaneswar",
            "salary": "25000.00"
        }
    ],
    "message": "Jobs Retrieved Successfully"
}