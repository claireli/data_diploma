#server.R
library("shiny")
library("FSelector")
GRADUATION_WITH_CENSUS_cleansed<-read.csv("GRADUATION_WITH_CENSUS_cleansed.csv")
g<-GRADUATION_WITH_CENSUS_cleansed[,c(3,5:25,40:581)]
g<-subset(g, select=-c(grep("MOE", colnames(g), perl=TRUE)))
COHORT_PCT<-function(COHORT, COHORT_TOTAL)
  COHORT_PCT<-COHORT/COHORT_TOTAL
return(COHORT_PCT)
MAM_PCT<-COHORT_PCT(g$MAM_COHORT_1112, g$ALL_COHORT_1112)
MAS_PCT<-COHORT_PCT(g$MAS_COHORT_1112, g$ALL_COHORT_1112)
MBL_PCT<-COHORT_PCT(g$MBL_COHORT_1112, g$ALL_COHORT_1112)
MHI_PCT<-COHORT_PCT(g$MHI_COHORT_1112, g$ALL_COHORT_1112)
MTR_PCT<-COHORT_PCT(g$MTR_COHORT_1112, g$ALL_COHORT_1112)
MWH_PCT<-COHORT_PCT(g$MWH_COHORT_1112, g$ALL_COHORT_1112)
CWD_PCT<-COHORT_PCT(g$CWD_COHORT_1112, g$ALL_COHORT_1112)
ECD_PCT<-COHORT_PCT(g$ECD_COHORT_1112, g$ALL_COHORT_1112)
LEP_PCT<-COHORT_PCT(g$LEP_COHORT_1112, g$ALL_COHORT_1112)
grad<-cbind(g, data.frame(cbind( MAM_PCT, MAS_PCT, MBL_PCT, MHI_PCT, MTR_PCT, MWH_PCT, CWD_PCT, ECD_PCT, LEP_PCT)))

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
      render_grad<-grad[ , sapply(grad, is.numeric)]
    }
  })
  # Generate a summary of the dataset
  output$Information <- renderDataTable({
    results<-information.gain(paste(input$Rate," ~."), render_grad())
    Variable<-rownames(results)
    Importance<-data.frame(results[1])
    colnames(Importance)<-c("Importance")
    stuff<-cbind(Variable, Importance)
  })
})