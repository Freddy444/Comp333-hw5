# Comp333-hw5
1. Unit testing
2. testing with pytest
3. PHPUnit testing - Backend
4. Jest testing - Frontend
5. Github Actions
6. Generative AI (testing)

For the backend I am using the same from the previous homework: https://github.com/Freddy444/Comp333-react-backend

# Problem 1: unit testing
To run my answer for the first problem. Simply run 'python3 unit_testing.py'. This should give you the wanted output.
 
# Problem 2: Testing with pytest

'test_script.py' contains unit tests for the functions in the `unit_testing_sample_code.py` script. These tests are implemented using the pytest framework.


## Setup

1. Install pytest using the following command:

```bash
pip install pytest
```

Ensure that the unit_testing_sample_code.py is in the same directory as this test script, which in this case is 'test_script.py'.


2. Running the Tests

pytest test_script.py

After running `pytest test_script.py` in your terminal, pytest will run the tests in the `test_script.py` file. The output will say whether each test passed or failed.


# Problem 3: PHP Unit testing 
Before you run the test, make sure your database meets the given requirements. For this assignement I used the same database here: https://github.com/Freddy444/Comp333-react-backend. Before you begine make sure to setup the database using XAMPP, and make sure Apache and MySQL are working.

I tested with a music list instead of a user list in my homework since a user list was not use din my original backend. 

What you need in your database before running (tests will fail if this si not done)
- One existing user (to test login)
- 2 songs under the existing user (use one to test delete and the other to test update)


1. Make a new folder called `testing-project` and then make it your working directory by inputting `cd testing-directory` into your terminal.
   
3. THen run `composer init` in your terminal and follow Zimmecks choice for the setup.

5. Then under the testing-project add the Tests folder I have on this repo, which contains my file with all the tests (BackendTest.php).

7. Before running anything, make sure to go through the tests file and edit parameters in order to prevent the tests from failing. If you're running for the first time. The only tests whose parameters you have to edit are:
   - testPOST_DeleteSong (change the song id - to any song id of the user you logged in as)
   - testPOST_UpdateSong (change the song id - to any song id of the user you logged in as)
   - testPOST_LoginUser (make sure to change parameters to a user that exists in your database. Remember to have atleast 2 songs under this user for the update song test and delete song test)

The rest of the function test parameters do not need to be edited, unless you wish to. The parameters I left should not cause any issues
  
5. run this in your terminal `composer require guzzlehttp/guzzle`

6. Now you are ready to run your tests with: `php vendor/bin/phpunit tests`

Here is a picture of all my tests passing:
<img width="820" alt="Screenshot 2023-12-01 at 2 07 22 AM" src="https://github.com/Freddy444/Comp333-hw5/assets/99642629/283a46ec-1352-44a2-bf64-a7d6d8736474">


# Problem 4: Jest testing
I will be using the same frontend from homework 3: https://github.com/Freddy444/Comp333-react-frontend/blob/main/README.md. The files with my tests are already there, they are named `loginview.test.js` and `registerview.test.js`. 

All instructions are located in my homewwork 3 frontend repo at the very bottom
