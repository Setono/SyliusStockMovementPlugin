@cli
Feature: Process reports
  In order to generate reports
  As a user
  I want to run the process command

  Scenario: Processing a report
    Given a report configuration is due
    And there are stock movements
    When I run the process command
    Then the command should run successfully
    And a report file should exist with the right content
