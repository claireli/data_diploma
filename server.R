library(shiny)
library(datasets)

# Define server logic required to summarize and view the selected
# dataset
shinyServer(function(input, output, session) {
  library(FSelector)
    
  output$Rate <- renderPrint(input$Rate)
  output$State <- renderPrint(input$State)
  stuff <-reactive({GRADUATION_WITH_CENSUS_cleansed[which(GRADUATION_WITH_CENSUS_cleansed$STNAM==input$State), ]})
  #rate<-reactive({input$Rate})
  # Return the requested dataset
 # datasetInput <- reactive({
  #  
#  })
  # Generate a summary of the dataset
  output$information <- renderTable({
    #stuff()
    #GRADUATION_WITH_CENSUS_cleansed[which(GRADUATION_WITH_CENSUS_cleansed$STNAM=="ALASKA"), ]
    stuff<-information.gain(paste(input$Rate," ~."), GRADUATION_WITH_CENSUS_cleansed[which(GRADUATION_WITH_CENSUS_cleansed$STNAM==input$State), ])
    stuff<-cbind(rownames(stuff), data.frame(stuff["attr_importance"], row.names=NULL))
    stuff[order(stuff$attr_importance, decreasing = TRUE), ]
  }, digits=4)
  
  # Show the first "n" observations

})