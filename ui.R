library("shiny")
grad_col<-read.csv("columns.csv")
grad_states<-read.csv("states.csv")
grad_col<-grad_col[,c(3,5:25,40:581)]
grad_col<-subset(grad_col, select=-c(grep("MOE", colnames(grad_col), perl=TRUE)))
# Define UI for dataset viewer application
shinyUI(
  fluidPage(
  # Application title
    titlePanel("Graduation Data"),
    # Sidebar with controls to select a dataset and specify the
    sidebarLayout(
      sidebarPanel("Inputs",
        helpText("Choose RATE and STATE of Interest"),
        selectInput("Rate", "RATE:", c(colnames(grad_col)[c(grep("RATE_1112", colnames(grad_col), perl=TRUE))])),
        selectInput("State", "STATE:",c("ALL STATES", as.character(grad_states$STNAM)))
        ),
      mainPanel(
        navbarPage(
          title = 'Tool Options',
          tabPanel('Important Variables', tableOutput('Information')),
          tabPanel('Univariate',
            selectInput("uni1", "Variable 1", c(colnames(grad_col[ , sapply(grad_col, is.numeric)]))),
            verbatimTextOutput("UnivariateFit")
            ),
          tabPanel('Bivariate',
            selectInput("bi1", "Variable 1", c(colnames(grad_col[ , sapply(grad_col, is.numeric)]))),
            selectInput("bi2", "Variable 2", c(colnames(grad_col[ , sapply(grad_col, is.numeric)]))),
            verbatimTextOutput("BivariateFit")
          ),
          tabPanel('Multivariate',
                   selectInput("multi1", "Variable 1", c(colnames(grad_col[ , sapply(grad_col, is.numeric)]))),
                   selectInput("multi2", "Variable 2", c(colnames(grad_col[ , sapply(grad_col, is.numeric)]))),
                   selectInput("multi3", "Variable 3", c(colnames(grad_col[ , sapply(grad_col, is.numeric)]))),
                   verbatimTextOutput("MultivariateFit")
          )
        )
      )
    )
  )
)