##Filter Examples

###Example Tables

####Users

 id | firstName | lastName
----|-----------|----------
 1  | Admin     | Admin
 2  | Helen     | Hardy
 3  | Greg      | Gable
 4  | Dan       | Doyle
 5  | Bob       | Bell
 6  | Alice     | Adams
 7  | Eve       | Evans
 8  | Fred      | Flint
 9  | Carol     | Carver
 10 | Ivan      | Idol
 11 | Jane      | Johnson

####Band

 id | name
----|------------------------
 1  | Electric End Users
 2  | Courageous Companies
 3  | Awesome Agencies
 4  | Dependable Departments
 5  | Fantastic Forms
 6  | Beautiful Billings

####BandMember

 id | band_id | user_id
----|---------|---------
 1  | 1       | 6
 2  | 1       | 5
 3  | 1       | 8
 4  | 2       | 4
 5  | 2       | 2
 6  | 3       | 6
 7  | 4       | 3
 8  | 4       | 4
 9  | 4       | 7
 10 | 5       | 9
 11 | 5       | 4
 12 | 5       | 6
 13 | 6       | 2
 14 | 6       | 3
 15 | 6       | 6
 16 | 6       | 8

####VenueType

 id | name
----|--------------------
 1  | The Garage
 2  | The Dive Bar
 3  | Wayside High
 4  | Comet Cash
 5  | Bar None
 6  | Dex Hall

####Gig

 id | band_id | venue_type_id | datetime
----|---------|---------------|------------------
 1  | 1       | 5             | 2015-06-06 19:00
 2  | 2       | 2             | 2015-06-07 19:00
 3  | 3       | 3             | 2015-06-08 19:00
 4  | 4       | 2             | 2015-06-09 19:00
 5  | 5       | 5             | 2015-06-10 19:00
 6  | 6       | 1             | 2015-06-11 19:00
 7  | 5       | 2             | 2015-06-12 19:00
 8  | 1       | 4             | 2015-06-13 19:00
 9  | 6       | 3             | 2015-06-14 19:00
 10 | 5       | 1             | 2015-06-15 19:00

####Entity

 id | name | database_name
----|------|---------------
 1  | Gig  | gig

####Association

 id | entity_id | name      | trail
----|-----------|-----------|-----------
 1  | 1         | Gig Band  | band
 2  | 1         | Gig Venue | venueType


####FilterCategory

 id | name
----|-------------
 1  | Talent Agent
 2  | Gig

####Join

 id | association_id | value
----|----------------|-------
 1  | 1              | 3
 2  | 2              | 5
 3  | 2              | 1
 4  | 1              | 6
 5  | 1              | 2
 6  | 1              | 4
 7  | 1              | 1
 8  | 1              | 5
 9  | 2              | 3
 10 | 2              | 4
 11 | 2              | 6
 12 | 2              | 2

####FilterCell

 id | description
----|----------------------------------
 1  | Awesome Agencies
 2  | Bar None or The Garage
 3  | Beautiful Billings
 4  | Courageous Companies
 5  | Dependable Departments
 6  | Electric End Users
 7  | Fantastic Forms
 8  | Wayside High
 9  | Beautiful Billings or Courageous Companies or Dependable Departments or Electric End Users
 10 | Bar None or Comet Cash
 11 | Dex Hall
 12 | Awesome Agencies or Fantastic Forms
 13 | The Dive Bar
 
####FilterCellJoin

 id | filter_cell_id | join_id
----|----------------|---------
 1  | 1              | 1
 2  | 2              | 2
 3  | 2              | 3
 4  | 3              | 4
 5  | 4              | 5
 6  | 5              | 6
 7  | 6              | 7
 8  | 7              | 8
 9  | 8              | 9
 10 | 9              | 4
 11 | 9              | 5
 12 | 9              | 6
 13 | 9              | 7
 14 | 10             | 2
 15 | 10             | 10
 16 | 11             | 11
 17 | 12             | 1
 18 | 12             | 8
 19 | 13             | 12

####FilterColumn

 id | description
----|---------------------------------------------------------------------------------------------------------------------------
 1  | Awesome Agencies
 2  | Awesome Agencies and (Bar None or The Garage)
 3  | Beautiful Billings
 4  | Courageous Companies
 5  | Dependable Departments
 6  | Electric End Users
 7  | Fantastic Forms
 8  | Fantastic Forms and Wayside High
 9  | (Beautiful Billings or Courageous Companies or Dependable Departments or Electric End Users) and (Bar None or Comet Cash)
 10 | Dependable Departments and Dex Hall
 11 | (Awesome Agencies or Fantastic Forms) and The Dive Bar

####FilterColumnCell

 id | filter_column_id | filter_cell_id
----|------------------|----------------
 1  | 1                | 1
 2  | 2                | 1
 2  | 2                | 2
 3  | 3                | 3
 4  | 4                | 4
 5  | 5                | 5
 6  | 6                | 6
 7  | 7                | 7
 8  | 8                | 7
 9  | 8                | 8
 10 | 9                | 9
 11 | 9                | 10
 12 | 10               | 5
 13 | 10               | 11
 14 | 11               | 12
 15 | 11               | 13

####Filter

 id | filter_category_id | name
----|--------------------|------------------------------------------------
 1  | 1                  | Awesome Agencies band
 2  | 2                  | AA band at Bar None/The Garage
 3  | 1                  | Beautiful Billings band
 4  | 1                  | Courageous Companies band
 5  | 1                  | Dependable Departments band
 6  | 1                  | Electric End Users band
 7  | 1                  | Fantastic Forms band
 8  | 2                  | FF band at Wayside High
 9  | 2                  | BB/CC/DD/EE bands at Bar None/Comet Cash
 10 | 2                  | DD at Dex Hall or ((AA or FF) at The Dive Bar)

####FilterRow

 id | filter_id | filter_column_id
----|-----------|----------
 1  | 1         | 1
 2  | 2         | 2
 3  | 3         | 3
 4  | 4         | 4
 5  | 5         | 5
 6  | 6         | 6
 7  | 7         | 7
 8  | 8         | 8
 9  | 9         | 9
 10 | 10        | 10
 11 | 10        | 11

####UserFilter

 id | user_id | filter_id
----|---------|-----------
 1  | 2       | 2
 2  | 2       | 6
 3  | 3       | 4
 4  | 3       | 6
 5  | 4       | 2
 6  | 4       | 4
 7  | 4       | 5
 8  | 5       | 1
 9  | 6       | 1
 10 | 6       | 5
 11 | 6       | 6
 12 | 6       | 3
 13 | 7       | 4
 14 | 8       | 1
 15 | 8       | 6
 16 | 9       | 5
 17 | 10      | 7
 18 | 10      | 2
 19 | 10      | 5
 20 | 10      | 6
 21 | 11      | 3
 22 | 11      | 4
 23 | 11      | 8
 24 | 11      | 1
 25 | 11      | 9

###How query builders will be affected

 logged in as | query builder       | filter categories applied | change
--------------|---------------------|---------------------------|-----------------------------------------------------------------------------------------------------------
 Admin Admin  | SELECT gig FROM gig | Gig                       | SELECT gig FROM gig
 Helen Hardy  | SELECT gig FROM gig | Gig                       | SELECT gig FROM gig WHERE 1 = 0
 Ivan Idol    | SELECT gig FROM gig | Gig                       | SELECT gig FROM gig JOIN venuetype entity0 WHERE ((entity0.id = 5 OR entity0.id = 1))
 Jane Johnson | SELECT gig FROM gig | Gig                       | SELECT gig FROM gig JOIN venuetype entity0 WHERE ((entity0.id = 3) OR (entity0.id = 5 OR entity0.id = 4))
