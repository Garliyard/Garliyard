# Garliyard
Garliyard is a web based wallet system that is built ontop of garlicoin's accounting system.  
This project is wirtten in the laravel framework.

## Why Open Source?
This project has been open sourced for the sole purpose of transparency, honesty and for all to contribute their ideas of what goes into the system that others use.

## Official Website
As of current, I do not have a dedicated domain for garliyard, and is piggy-backing on my personal website.  
You can find the current instance of Garliyard running at: https://garliyard.elyc.in/

In the event that the website becomes unresponsive or starts tossing errors, please check to see if the system is overloaded by looking at our [netdata instance](https://sandbox.corsair.house/).

## Current Features
- Wallet balance confirmed after 3 transaction confirmations
- Two Factor Authentication
    - Yubikey (OTP)
    - Google Authenticator (TOTP)
- Redis Caching
    - The Redis cache is implemented to store temporary values for a fixed amount of time
    - This allows more JSONRPC calls to be made to Garlicoin.
- 100 Unique Addresses
    - Mature accounts can have a maximum of 100 unique Garlicoin Addresses.
    - Accounts that are less than an hour old are limited to 10 to prevent spam
 - Statistics
     - These statistics are entirely anonymous, and taken as a collective sum
 - Transaction History
 - Address Labeling
 - QR Code Generator
 
 ## Planned FEatures
 - Integrated blockchain explorer
 - REST API