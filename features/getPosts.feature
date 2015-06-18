Feature: Scraping command
  In order to get the scraped VDM's post
  As a user
  I need to access "GET posts" API call

  Scenario:
    Given I have an HTTP Client
    When I GET "/api/v1/posts"
    Then I should get a "application/JSON" content-type
    And I should get a JSON array of "Post"
