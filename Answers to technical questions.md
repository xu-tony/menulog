1. How long did you spend on the coding test? What would you add to your solution if you had more time? If you didn't spend much time on the coding test then use this as an opportunity to explain what you would add.
A: I have spend 8 hours in total on this project. I'm using ZF2 as my mvc, and my structure is ready to expand more feature which the JeAPI providing.
I'm also using Angularjs as my data present, but I don't have much time on the ng-sanitize and ng-custom-validation part. I will add it if i have more time.
Every time when we make a new single restaurant product request, it has to do a lots API requests includes getMenus, getCategories, and finally get products.
I want to use some parallel http request, like using RabbitMQ as my queue system, create more worker to do the request in parallel, and save the result to Redis,
Another service can only go to redis to grab the result according to the key. I have spend pretty much time on unit test, I focus on the service and api test,
i did a few examples, basically I make the mocking for each dependency and the testing methodology is built in the existing example.

2. What was the most useful feature that was added to the latest version of your chosen language? Please include a snippet of code that shows how you've used it.
The most useful feature is the cache system, we save a lots of responding time when the user doing the same restaurant or postcode search.

3. How would you track down a performance issue in production? Have you ever had to do this?
My app is deployed in my AWS instance, so I can use some AWS performance tool like "newrelic" to monitor its performance.
We are also using new relic in my current company.

4. How would you improve the JUST EAT APIs that you just used?
The overall response time of JEAPI is slow, even when i do the same request, not sure if you are using cache or not. And also there is not a feature to get
all products for one single restaurant, we have to get the menus and then get the categories, finally can get the products, it's pretty complicated.
All these is what i want to improve.

5. Please describe yourself using JSON.

`    {
        "status":"husband, father"
        "hobby": ""
        "age": ""
        "career":[
            {
            },
            {
            }
        ],
        "ITBackground":{
        }
    }`
