library(shiny)
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
# Define UI for dataset viewer application
shinyUI(
  fluidPage(
  # Application title
    titlePanel("Graduation Data"),
    # Sidebar with controls to select a dataset and specify the
    sidebarLayout(
      sidebarPanel("Inputs",
        helpText("Choose RATE and STATE of Interest"),
        selectInput("Rate", "RATE:", c(colnames(grad)[c(grep("RATE_1112", colnames(grad), perl=TRUE))])),
        selectInput("State", "STATE:",c("ALL STATES", unique(as.character(grad$STNAM))))
        ),
      mainPanel(
        navbarPage(
          title = 'Tool Options',
          tabPanel('Important Variables', dataTableOutput('Information')),
          tabPanel('Univariate',
            selectInput("uni1", "Variable 1", c(colnames(grad[ , sapply(grad, is.numeric)]))),
            verbatimTextOutput("UnivariateFit")
            ),
          tabPanel('Bivariate',
            selectInput("bi1", "Variable 1", c(colnames(grad[ , sapply(grad, is.numeric)]))),
            selectInput("bi2", "Variable 2", c(colnames(grad[ , sapply(grad, is.numeric)]))),
            verbatimTextOutput("BivariateFit")
          ),
          tabPanel('Multivariate',
                   selectInput("multi1", "Variable 1", c(colnames(grad[ , sapply(grad, is.numeric)]))),
                   selectInput("multi2", "Variable 2", c(colnames(grad[ , sapply(grad, is.numeric)]))),
                   selectInput("multi3", "Variable 3", c(colnames(grad[ , sapply(grad, is.numeric)]))),
                   verbatimTextOutput("MultivariateFit")
          )
        )
      )
    )
  )
)