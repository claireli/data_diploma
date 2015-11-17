#server.R
library('shiny')
library('FSelector')
grad<-readRDS("grad.rds")
shinyServer(function(input, output, session) {
  render_grad<-reactive({
    if (input$State=="ALL STATES"){
      render_grad<-grad[ , sapply(grad, is.numeric)]
    }else {
      render_grad<-grad[which(grad$STNAM==input$State), ]
      render_grad<-render_grad[ , sapply(grad, is.numeric)]
    }
  })
  output$Information <- renderTable({
    results<-information.gain(paste(input$Rate," ~."), render_grad())
    Variable<-rownames(results)
    Importance<-data.frame(results[1])
    colnames(Importance)<-c("Importance")
    results<-cbind(Variable, Importance)
    rownames(results)<-NULL
    results[order(results$Importance, decreasing=TRUE),]
  }, digits=3)
  output$UnivariateFit<-renderPrint({
    if (input$Rate==input$Uni1){
      "Invalid Variable"
    } else{
      uniformula<-paste(input$Rate," ~ ", input$Uni1)
      unifit<-lm(uniformula, data = render_grad())
      summary(unifit)
    }
  })
  output$BivariateFit<-renderPrint({
    if (input$Rate==input$Bi1 || input$Rate==input$Bi2){
      "Invalid Variable(s)"
    } else{
      biformula<-paste(input$Rate," ~ ", input$Bi1, " + ", input$Bi2)
      bifit<-lm(biformula, data = render_grad())
      summary(bifit)
    }
  })
  output$MultivariateFit<-renderPrint({
    if (input$Rate==input$Multi1 || input$Rate==input$Multi2 || input$Rate==input$Multi3){
      "Invalid Variable(s)"
    } else{
      multiformula<-paste(input$Rate," ~ ", input$Multi1, " + ", input$Multi2, " + ", input$Multi3)
      multifit<-lm(multiformula, data = render_grad())
      summary(multifit)
    }
  })
  output$posterior<-renderTable({
    GRADUATE_NOT<-sum(((1-render_grad()$ALL_RATE_1112/100)*render_grad()$ALL_COHORT_1112), na.rm=TRUE)
    MAM<-sum(((1-render_grad()$MAM_RATE_1112/100)*render_grad()$MAM_COHORT_1112), na.rm=TRUE)/GRADUATE_NOT
    MAS<-sum(((1-render_grad()$MAS_RATE_1112/100)*render_grad()$MAS_COHORT_1112), na.rm=TRUE)/GRADUATE_NOT
    MBL<-sum(((1-render_grad()$MBL_RATE_1112/100)*render_grad()$MBL_COHORT_1112), na.rm=TRUE)/GRADUATE_NOT
    MHI<-sum(((1-render_grad()$MHI_RATE_1112/100)*render_grad()$MHI_COHORT_1112), na.rm=TRUE)/GRADUATE_NOT
    MTR<-sum(((1-render_grad()$MTR_RATE_1112/100)*render_grad()$MTR_COHORT_1112), na.rm=TRUE)/GRADUATE_NOT
    MWH<-sum(((1-render_grad()$MWH_RATE_1112/100)*render_grad()$MWH_COHORT_1112), na.rm=TRUE)/GRADUATE_NOT
    CWD<-sum(((1-render_grad()$CWD_RATE_1112/100)*render_grad()$CWD_COHORT_1112), na.rm=TRUE)/GRADUATE_NOT
    ECD<-sum(((1-render_grad()$ECD_RATE_1112/100)*render_grad()$ECD_COHORT_1112), na.rm=TRUE)/GRADUATE_NOT
    LEP<-sum(((1-render_grad()$LEP_RATE_1112/100)*render_grad()$LEP_COHORT_1112), na.rm=TRUE)/GRADUATE_NOT
    posterior<-t(data.frame(cbind(MAM, MAS, MBL, MHI, MTR, MWH, CWD, ECD, LEP)))
  })
  
})