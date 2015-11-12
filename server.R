library(shiny)
library(datasets)
library(FSelector)
# Define server logic required to summarize and view the selected
# dataset
shinyServer(function(input, output, session) {
  library(FSelector)
    
  output$Rate <- renderPrint(input$Rate)
  output$State <- renderPrint(input$State)
  
  
  # Return the requested dataset
  datasetInput <- reactive({
    GRADUATION_WITH_CENSUS_cleansed[which(GRADUATION_WITH_CENSUS_cleansed$STNAM==input$State)]
  })
  # Generate a summary of the dataset
  output$information <- renderPrint({
    dataset <- datasetInput()
    information = information.gain(input$Rate~. , dataset)
  })
  
  # Show the first "n" observations

})