Feature: Scraping command
  In order to get VDM's post in DB
  As a user
  I need to automatically scrape VDM

  Scenario:
    Given I am in root directory
    When I run "php app/console vdm:scrape"
    And answer "y" to question
    Then I should get "scraped." in console
    And I should get 200 lines in "Post" table
