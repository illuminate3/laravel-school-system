## School management system in Laravel 5.3

Management system for all types of educational institutions like schools and colleges.

###Requirements
* Before purchasing, please make sure your server has at least php 5.6.4 and below requirements from Laravel apply
* PHP >= 5.6.4
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension

**For install use custom install process that integrate into SMS system**

**Before install, please read in user manual folder file "before_install.pdf"**

**During installation you can select multi school system or not**

Integrates and facilitates 9 types of user accounts of a school :

* [Super Administrator](#superadministrator)
* [Administrator](#administrator)
* [Human resurces](#humanresources)
* [Accountant](#accountant)
* [Librarian](#librarian)
* [Teacher](#teacher)
* [Student](#student)
* [Parent](#parent)
* [Visitor](#visitor)

Features:

###Super Administrator
* Add / edit / delete schools
* Add / edit / delete school admins
* Add / edit / delete school years
* Add / edit / delete semesters
* Add / edit / delete directions
* Add / edit / delete subjects
* Add / edit / delete mark type
* Add / edit / delete mark value
* Add / edit / delete notice type
* Add / edit / delete fee categories
* See registered visitors
* See login history
* Add / edit / delete static pages
* Add / edit / delete certificate
* Set up settings
* Add / edit / delete schools options
* Sent message to any user in system
* Paypal email in system settings is paypal payment gateway for student invoice online payments
* Define subject fee
* Add tasks to school admin
* Can add task to school admin
* Create invoices to all students that learn some subject if that subject have fee
* Can define method for late Book return and price
* Manage own profile
* Access account from anywhere, by any device like desktop, laptop, smart phone and tablet

###Administrator
* Manage students class/group wise
* Add / edit / delete student
* View profile of students
* Manage holidays and show them on calender
* Manage teacher profile
* Add / edit / delete teacher information
* Manage parent according to student class wise
* Create / edit / delete sections / group for students
* Subjects can be defined separately according to each classes
* Manage class routine
* Create / edit / delete class routine schedule on 7days a week
* Manage payment for student
* Create / edit / delete parents
* Create / edit / delete human resources
* See registered visitors
* Create / edit / delete invoice listing
* View invoice and print them
* Manage transportation routes for school
* Manage dormitory listing for school
* Manage noticeboard of school
* Menage messages for school users
* Create / edit / delete notices according to date
* Notices are visible in calendar in dashboard
* Add certificate to users
* Finish tasks from Super admin
* Send SMS message to any user who had a mobile phone
* Create invoices to all students in his school that learn some subject if that subject have fee
* View teacher diaries
* Add transfer certificate for student
* Define directions for school
* Add resume to teacher
* Edit system settings
* Manage own profile
* Access account from anywhere, by any device like desktop, laptop, smart phone and tablet

###Human Resources
* Create / edit / delete parents
* Create / edit / delete students
* Create / edit / delete librarian
* Create / edit / delete teachers
* Create / edit / delete staff attendance
* Create / edit / delete salary
* Manage own profile
* Access account from anywhere, by any device like desktop, laptop, smart phone and tablet

###Accountant
* Create / edit / delete invoice
* Create / edit / delete payments
* Create / edit / delete staff attendance
* Create / edit / delete salary
* Manage own profile
* Access account from anywhere, by any device like desktop, laptop, smart phone and tablet

###Librarian
* Manage library
* Create / edit / delete book list
* Issue book to any user
* Return book from any user
* See reserved books from any user
* List of user that issued the book in book details
* Tasks for librarian (created by himself)
* Make invoice for late Book return
* Manage own profile
* Access account from anywhere, by any device like desktop, laptop, smart phone and tablet
* **REST API for this role**

###Teacher
* Manage students class/group wise
* Add / edit / delete diaries
* View profile of students
* View mark sheet of student
* View teacher profile
* Manage exam / semester listing
* Manage marks (edit/ update) and attendance exam,class & student wise
* View class routine
* View library and book status
* View school transportation routes status
* View / edit noticeboard or school events
* Create online exams
* Manage own profile
* Add study materials for his subject
* Access account from anywhere, by any device like desktop, laptop, smart phone and tablet
* **REST API for this role**

###Student
* View own class subjects
* View teacher diaries
* View own marks and attendances
* View class routine
* View invoice and payment list
* View library and book status
* Book reservation
* View school transportation and routes status
* View dormitory listing and their status
* View noticeboard and school events in calendar
* Online payment can be paid via [paypal] and [scrill]
* View own certificate
* Manage own profile
* View own student card
* Solving online exams
* Access account from anywhere, by any device like desktop, laptop, smart phone and tablet
* **REST API for this role**

###Parent
* View own children marks and attendances and other comments from teacher
* View own children class routine
* View teacher diaries
* View own children invoice and payment list
* Make online or offline payment
* Online payment can be paid via [paypal] and [scrill]
* View library and book status
* View school transportation and routes status
* View dormitory listing and their status
* View noticeboard and school events in calendar
* Manage own profile
* Access account from anywhere, by any device like desktop, laptop, smart phone and tablet
* **REST API for this role**

###Visitor
* View own visitor card
* Manage own profile
* Access account from anywhere, by any device like desktop, laptop, smart phone and tablet