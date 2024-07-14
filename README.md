# backend

1) For start project:
sudo make start

2) Open in browser:
http://localhost:8000/

3) Tests:
make test-unit

   
The implementation used the standard symfony approach. 
The controller has minimal logic and calls a service in which we process business logic. 
The service can call some external client/repository logic.

For improvement and the right approach. I would move the logic for sending email to queue.
Since the system uses the MailSenderInterface interface to send a mail, 
the implementation can be easily replaced by sending it to a queue and subsequent processing asynchronously.