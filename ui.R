library(shiny)

GRADUATION_WITH_CENSUS_cleansed<-read.csv("GRADUATION_WITH_CENSUS_cleansed.csv")
# Define UI for dataset viewer application
shinyUI(fluidPage(
  # Application title
  titlePanel("Graduation Data"),
  
  # Sidebar with controls to select a dataset and specify the
  # number of observations to view
  sidebarLayout(
    sidebarPanel("Controls",
      helpText("Find out the most important variables regarding graduation rates by choosing fromt the drop downs below"),
      
      selectInput("Rate", "COHORT_RATE:", 
                  c(colnames(GRADUATION_WITH_CENSUS_cleansed)[c(grep("RATE_1112", colnames(GRADUATION_WITH_CENSUS_cleansed), perl=TRUE))])),
      selectInput("State", "Choose a STATE:",
                  c(unique(as.character(GRADUATION_WITH_CENSUS_cleansed$STNAM))))
      ),
    # Show a summary of the dataset and an HTML table with the
    
    
    # requested number of observations
    mainPanel(
      verbatimTextOutput('Rate'),
      verbatimTextOutput('State'),
      tableOutput('information')
    )
  )
))