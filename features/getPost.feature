Feature: Scraping command
  In order to get one scraped post
  As a user
  I need to access "GET post" API call

  Scenario:
    Given I have an HTTP Client
    When I GET "/api/v1/post/8553267"
    Then I should get a "application/JSON" content-type
    And I should get a JSON object "Post"
    And I should get a JSON "id" attribute of "8553267"
