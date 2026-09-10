TORQUE FLOW

Torque Flow is a PHP and MySQL vehicle service booking application. It gives customers a simple way to choose a service, select a service center, describe a vehicle issue, and track the booking. It also gives service centers a focused workspace for reviewing and responding to their own bookings. Administrators manage the service catalogue and service center network.

PROJECT PURPOSE

The project supports the complete service booking journey from service discovery to booking confirmation. The public pages introduce the Torque Flow brand and services. Registered customers can book a service. Service center staff can view new bookings and mark them as confirmed or not confirmed. Administrators can manage the services and centers available to customers.

FEATURES

The public website includes a home page, services page, about page, contact page, registration page, and login page.

Customer features include registration, login, service browsing, service booking, service center selection, booking date selection, problem descriptions, and booking status tracking.

Service center features include login, new booking review, booking confirmation, booking rejection, all booking reports, confirmed booking reports, and not confirmed booking reports. Each service center sees bookings assigned to its own center.

Administrator features include login, service type creation, service type editing, service type deletion, service image upload, service center creation, service center editing, and service center deletion.

TECHNOLOGY

The application uses PHP for server side processing and MySQL for data storage. The interface is built with HTML, CSS, and JavaScript. Google Fonts are used for the Archivo, DM Sans, and IBM Plex Mono typefaces. The project is designed to run on a local PHP environment such as WampServer.

PROJECT STRUCTURE

index.php is the public home page.

services.php, about.php, and contact.php are the public information pages.

registration.php creates customer accounts.

login.php authenticates administrators, customers, and service centers. It stores the customer ID and service center ID in the active session after a successful login.

cust_view_service_type.php displays services available for booking.

cust_book_service.php creates a customer service booking.

cust_view_service_booking_status.php displays a customer booking history and its current status.

center_view_new_booking.php shows new bookings for the logged in service center.

center_view_booking_report.php, center_view_confirm_booking_report.php, and center_view_notconfirm_booking_report.php provide service center booking reports.

admin_manage_type.php manages service types.

admin_manage_service_center.php manages service centers.

connection.php contains the MySQL connection settings.

css contains the site styles. portal.css and portal_footer.css provide the customer and service center interface theme.

images and type_img contain website and service images.

LOCAL SETUP

Install and start WampServer or another local stack that includes Apache, PHP, and MySQL.

Copy the Torque Flow project folder into the web root. For WampServer the usual location is the www directory.

Create a MySQL database named torque_flow.

Update connection.php if the local database host, username, password, or database name differs from the default local configuration.

Import the project database structure and data. The application expects the admin_detail, cust_regis, service_center_info, type_info, and service_booking_info tables.

Start Apache and MySQL, then open the project through the local server using the Torque Flow folder name.

USER FLOW

A new customer creates an account on the registration page and logs in from the login page. After login, the customer can choose a service type, select a service center, provide a problem description, choose a date, and submit a booking. The selected service center receives the booking in its new bookings screen.

Service center staff log in with their own credentials. The active session stores their center ID, which filters each booking screen so the center only sees bookings assigned to that location.

Administrators log in to manage services and service centers. These services become available to customers in the booking flow.

BOOKING STATUS

New Booking means a service center has not yet responded.

Confirm means the service center has accepted the booking.

Not Confirm means the service center has declined the booking.

DEVELOPMENT NOTES

The project uses PHP sessions to identify the active customer and service center. A successful customer login must set custid. A successful service center login must set center_id. These values are required when creating and filtering bookings.

Service images uploaded by an administrator are stored in the type_img directory. Ensure the local web server has permission to write to this directory when using image upload.

The existing implementation is intended for local development and educational use. Before deploying publicly, protect passwords with password hashing, use prepared statements for database access, validate authorization on every protected page, and move database credentials out of source control.

TROUBLESHOOTING

If the application cannot connect to the database, confirm that MySQL is running, the torque_flow database exists, and the values in connection.php match the local environment.

If a customer booking shows an empty customer ID error, log out and log in again so the customer session is created.

If a service center cannot see bookings assigned to it, log out and log in again so the current center ID is stored in the session.

If service images do not display, confirm that the file exists in type_img and that its stored path is correct.
