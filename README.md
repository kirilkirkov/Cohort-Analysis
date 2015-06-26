# Cohort-Analysis
## Cohort Analysis php generator from given array

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
