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

####Venue

 id | name
----|--------------
 1  | The Garage
 2  | The Dive Bar
 3  | Wayside High
 4  | Comet Cash
 5  | Bar None
 6  | Dex Hall

####Gig

 id | band_id | venue_id | datetime
----|---------|----------|------------------
 1  | 1       | 5        | 2015-06-06 19:00
 2  | 2       | 2        | 2015-06-07 19:00
 3  | 3       | 3        | 2015-06-08 19:00
 4  | 4       | 2        | 2015-06-09 19:00
 5  | 5       | 5        | 2015-06-10 19:00
 6  | 6       | 1        | 2015-06-11 19:00
 7  | 5       | 2        | 2015-06-12 19:00
 8  | 1       | 4        | 2015-06-13 19:00
 9  | 6       | 3        | 2015-06-14 19:00
 10 | 5       | 1        | 2015-06-15 19:00

####FilterEntity

 id | name | database_name
----|------|---------------
 1  | Gig  | gig

####FilterAssociation

 id | filter_entity_id | name      | trail
----|------------------|-----------|-----------
 1  | 1                | Gig Band  | band
 2  | 1                | Gig Venue | venue

####FilterCategory

 id | name         | code_name
----|--------------|---------------------
 1  | Talent Agent | FILTER_TALENT_AGENT
 2  | Gig          | FILTER_GIG

####FilterJoin

 id | filter_association_id | value | description
----|-----------------------|-------|-----------------------------------
 1  | 1                     | 3     | Gig Band = Awesome Agencies
 2  | 2                     | 5     | Gig Venue = Bar None
 3  | 2                     | 1     | Gig Venue = The Garage
 4  | 1                     | 6     | Gig Band = Beautiful Billings
 5  | 1                     | 2     | Gig Band = Courageous Companies
 6  | 1                     | 4     | Gig Band = Dependable Departments
 7  | 1                     | 1     | Gig Band = Electric End Users
 8  | 1                     | 5     | Gig Band = Fantastic Forms
 9  | 2                     | 3     | Gig Venue = Wayside High
 10 | 2                     | 4     | Gig Venue = Comet Cash
 11 | 2                     | 6     | Gig Venue = Dex Hall
 12 | 2                     | 2     | Gig Venue = The Dive Bar

####FilterCell

 id | description
----|--------------------------------------------------------------------------------------------
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

 filter_cell_id | filter_join_id
----------------|----------------
 1              | 1
 2              | 2
 2              | 3
 3              | 4
 4              | 5
 5              | 6
 6              | 7
 7              | 8
 8              | 9
 9              | 4
 9              | 5
 9              | 6
 9              | 7
 10             | 2
 10             | 10
 11             | 11
 12             | 1
 12             | 8
 13             | 12

####FilterRow

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

####FilterRowCell

 filter_row_id | filter_cell_id
---------------|----------------
 1             | 1
 2             | 1
 2             | 2
 3             | 3
 4             | 4
 5             | 5
 6             | 6
 7             | 7
 8             | 7
 8             | 8
 9             | 9
 9             | 10
 10            | 5
 10            | 11
 11            | 12
 11            | 13

####Filter

 id | filter_category_id | description
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

####FilterRowFilter

 filter_row_id | filter_id
---------------|-----------
 1             | 1
 2             | 2
 3             | 3
 4             | 4
 5             | 5
 6             | 6
 7             | 7
 8             | 8
 9             | 9
 10            | 10
 10            | 11

####UserFilter

 user_id | filter_row_id
---------|---------------
 2       | 2
 2       | 6
 3       | 4
 3       | 6
 4       | 2
 4       | 4
 4       | 5
 5       | 1
 6       | 1
 6       | 5
 6       | 6
 6       | 3
 7       | 4
 8       | 1
 8       | 6
 9       | 5
 10      | 7
 10      | 2
 10      | 5
 10      | 6
 11      | 3
 11      | 4
 11      | 8
 11      | 1
 11      | 9

###How query builders will be affected

 logged in as | query builder       | filter categories applied | change
--------------|---------------------|---------------------------|-----------------------------------------------------------------------------------------------------------
 Admin Admin  | SELECT gig FROM gig | Gig                       | SELECT gig FROM gig
 Helen Hardy  | SELECT gig FROM gig | Gig                       | SELECT gig FROM gig WHERE 1 = 0
 Ivan Idol    | SELECT gig FROM gig | Gig                       | SELECT gig FROM gig JOIN venuetype entity0 WHERE ((entity0.id = 5 OR entity0.id = 1))
 Jane Johnson | SELECT gig FROM gig | Gig                       | SELECT gig FROM gig JOIN venuetype entity0 WHERE ((entity0.id = 3) OR (entity0.id = 5 OR entity0.id = 4))
