library('shiny')
grad_col<-readRDS("grad_col.rds")
grad_states<-readRDS("grad_states.rds")
# Define UI for dataset viewer application
shinyUI(
  fluidPage(
  # Application title
    titlePanel("Graduation Data"),
    # Sidebar with controls to select a dataset and specify the
    sidebarLayout(
      sidebarPanel("Panel",
        helpText("Choose RATE and STATE of Interest"),
        selectInput('Rate', "RATE:", c(colnames(grad_col)[c(grep("RATE_1112", colnames(grad_col), perl=TRUE))])),
        selectInput('State', "STATE:",c("ALL STATES", grad_states$STNAM)),
        submitButton('Submit/Refresh'),
        helpText("State Failure Posteriors"),
        tableOutput('posterior')
        
        ),
      mainPanel(
        navbarPage(
          title = "Tool Options",
          tabPanel("Important Variables", tableOutput('Information')),
          tabPanel("Univariate",
            selectInput('Uni1', "Variable 1", c(colnames(grad_col[ , sapply(grad_col, is.numeric)]))),
            verbatimTextOutput("UnivariateFit")
            ),
          tabPanel("Bivariate",
            selectInput('Bi1', "Variable 1", c(colnames(grad_col[ , sapply(grad_col, is.numeric)]))),
            selectInput('Bi2', "Variable 2", c(colnames(grad_col[ , sapply(grad_col, is.numeric)]))),
            verbatimTextOutput('BivariateFit')
          ),
          tabPanel("Multivariate",
                   selectInput('Multi1', "Variable 1", c(colnames(grad_col[ , sapply(grad_col, is.numeric)]))),
                   selectInput('Multi2', "Variable 2", c(colnames(grad_col[ , sapply(grad_col, is.numeric)]))),
                   selectInput('Multi3', "Variable 3", c(colnames(grad_col[ , sapply(grad_col, is.numeric)]))),
                   verbatimTextOutput('MultivariateFit')
          )
        )
      )
    )
  )
)