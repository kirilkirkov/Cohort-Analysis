# Cohort-Analysis
## Cohort Analysis php generator from given array

### What is Cohort Analysis ?
* Cohort analysis is a subset of behavioral analytics that takes the data from a given eCommerce platform, web application, or online game and rather than looking at all users as one unit, it breaks them into related groups for analysis. These related groups, or cohorts, usually share common characteristics or experiences within a defined timespan. Cohort analysis allows a company to “see patterns clearly across the lifecycle of a customer (or user), rather than slicing across all customers blindly without accounting for the natural cycle that a customer undergoes. By seeing these patterns of time, a company can adapt and tailor its service to those specific cohorts. While cohort analysis is sometimes associated with a cohort study, they are different and should not be viewed as one in the same. Cohort analysis has come to describe specifically the analysis of cohorts in regards to big data and business analytics, while a cohort study is a more general umbrella term that describes a type of study in which data is broken down into similar groups.
* See more at: https://en.wikipedia.org/wiki/Cohort_analysis
* See more at: http://andrewchen.co/the-easiest-spreadsheet-for-churn-mrr-and-cohort-analysis-guest-post/

### Script was created from here with little differences:
* 


### Using:
* Include 3D Array with name $months_pays in cohort.php example in this variant (values are ids of users):
```php
Array
(
    [Jan-15] => Array
        (
            [Jan-15] => Array
                (
                    [0] => 4981
                )

            [Feb-15] => Array
                (
                    [0] => 4981
                )

            [Mar-15] => Array
                (
                    [0] => 4981
                )

        )

    [Feb-15] => Array
        (
            [Jan-15] => Array
                (
                )

            [Feb-15] => Array
                (
                    [0]=> 193
                    [1]=> 525
                )

            [Mar-15] => Array
                (
                    [0]=> 193
                    [1]=> 525
                )

        )

    [Mar-15] => Array
        (
            [Jan-15] => Array
                (
                )

            [Feb-15] => Array
                (
                )

            [Mar-15] => Array
                (
                    [0]=> 593
                    [1]=> 316
                    [2]=> 743
                )

        )
)
```

* And include 3D Array with name $months_moneys in cohort.php example in this variant (values are given money from user):
```php
Array
(
    [Jan-15] => Array
        (
            [Jan-15] => Array
                (
                    [4981] => 100
                )

            [Feb-15] => Array
                (
                    [4981] => 100
                )

            [Mar-15] => Array
                (
                    [4981] => 100
                )

        )

    [Feb-15] => Array
        (
            [Jan-15] => Array
                (
                )

            [Feb-15] => Array
                (
                    [193]=> 200
                    [525]=> 300
                )

            [Mar-15] => Array
                (
                    [193]=> 200
                    [525]=> 300
                )

        )

    [Mar-15] => Array
        (
            [Jan-15] => Array
                (
                )

            [Feb-15] => Array
                (
                )

            [Mar-15] => Array
                (
                    [593]=> 300
                    [316]=> 400
                    [743]=> 500
                )

        )
)
```

* Example of cohort bootstrap style:<br>
![alt tag](https://raw.githubusercontent.com/kirilkirkov/Cohort-Analysis/master/bootstrap-cohort-screen.jpg)
