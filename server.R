#server.R
library("shiny")
library("FSelector")
grad<-readRDS("grad.rds")
shinyServer(function(input, output, session) {
  output$UnivariateFit<-renderPrint({
    if (input$Rate==input$uni1){
      "Invalid Variable"
    } else{
      uniformula<-paste(input$Rate," ~ ", input$uni1)
      unifit<-lm(uniformula, data = render_grad())
      summary(unifit)
    }
  })
  output$BivariateFit<-renderPrint({
    if (input$Rate==input$bi1 || input$Rate==input$bi2){
      "Invalid Variable(s)"
    } else{
      biformula<-paste(input$Rate," ~ ", input$bi1, " + ", input$bi2)
      bifit<-lm(biformula, data = render_grad())
      summary(bifit)
    }
  })
  output$MultivariateFit<-renderPrint({
    if (input$Rate==input$multi1 || input$Rate==input$multi2 || input$Rate==input$multi3){
      "Invalid Variable(s)"
    } else{
      multiformula<-paste(input$Rate," ~ ", input$multi1, " + ", input$multi2, " + ", input$multi3)
      multifit<-lm(multiformula, data = render_grad())
      summary(multifit)
    }
  })
  render_grad<-reactive({
    if (input$State=="ALL STATES"){
      render_grad<-grad[ , sapply(grad, is.numeric)]
    }else {
      render_grad<-grad[which(grad$STNAM==input$State), ]
      render_grad<-render_grad[ , sapply(grad, is.numeric)]
    }
  })
   #Generate a summary of the dataset
  output$Information <- renderTable({
    results<-information.gain(paste(input$Rate," ~."), render_grad())
    Variable<-rownames(results)
    Importance<-data.frame(results[1])
    colnames(Importance)<-c("Importance")
    stuff<-cbind(Variable, Importance)
    rownames(stuff)<-NULL
    stuff[order(stuff$Importance, decreasing=TRUE),]
  })
})