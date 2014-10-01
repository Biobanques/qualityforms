/* 
 * command to create the admin user for this db.
 * only available since mongo 2.6
 */

db.createUser(
{ user: "qfuseradmin",
  pwd: "bbanques2015",
  roles: [
    {role:"userAdmin",db:"qualityformsdb"}
  ]
}
        )