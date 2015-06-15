##Filter Examples

For these examples, the following tables will be assumed

###Users

 id | firstName | lastName
----|-----------|----------
 1  | Helen     | Hardy
 2  | Greg      | Gable
 3  | Dan       | Doyle
 4  | Bob       | Bell
 5  | Alice     | Adams
 6  | Eve       | Evans
 7  | Fred      | Flint
 8  | Carol     | Carver
 9  | Ivan      | Idol
 10 | Jane      | Johnson

###Band

 id | name
----|------------------------
 1  | Electric End Users
 2  | Courageous Companies
 3  | Awesome Agencies
 4  | Dependable Departments
 5  | Fantastic Forms
 6  | Beautiful Billings

###BandMember

 id | band_id | user_id
----|---------|---------
 1  | 1       | 5
 2  | 1       | 4
 3  | 1       | 7
 4  | 2       | 3
 5  | 2       | 1
 6  | 3       | 5
 7  | 4       | 2
 8  | 4       | 3
 9  | 4       | 6
 10 | 5       | 8
 11 | 5       | 3
 12 | 5       | 5
 13 | 6       | 1
 14 | 6       | 2
 15 | 6       | 5
 16 | 6       | 7

###VenueType

 id | name
----|----------------
 1  | garage
 2  | birthday party
 3  | school dance
 4  | coffee shop
 5  | bar
 6  | concert

### FilterCategory

 id | name
----|-------------
 1  | Talent Agent
 2  | Band Venue

### Filter

 id | filter_category_id | name                                   | solvent
----|--------------------|----------------------------------------|----------------------------------------
 1  | 1                  | Awesome Agencies band                  | band = 3
 2  | 2                  | AA band at bars/garages                | band = 3 and venuetype = 5, 1
 3  | 1                  | Beautiful Billings band                | band = 6
 4  | 1                  | Courageous Companies band              | band = 2
 5  | 1                  | Dependable Departments band            | band = 4
 6  | 1                  | Electric End Users band                | band = 1
 7  | 1                  | Fantastic Forms band                   | band = 5
 8  | 2                  | FF band at school dances               | band = 5 and venuetype = 3
 9  | 2                  | BB/CC/DD/EE bands at bars/coffee shops | band = 6, 2, 4, 1 and venuetype = 5, 4

### UserFilter

 id | user_id | filter_id
----|---------|-----------
 1  | 1       | 2
 2  | 1       | 6
 3  | 2       | 4
 4  | 2       | 6
 5  | 3       | 2
 6  | 3       | 4
 7  | 3       | 5
 8  | 4       | 1
 9  | 5       | 1
 10 | 5       | 5
 11 | 5       | 6
 12 | 5       | 3
 13 | 6       | 4
 14 | 7       | 1
 15 | 7       | 6
 16 | 8       | 5
 17 | 9       | 7
 18 | 9       | 2
 19 | 9       | 5
 20 | 9       | 6
 21 | 10      | 3
 22 | 10      | 4
 23 | 10      | 8
 23 | 10      | 1



 