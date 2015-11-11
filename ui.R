library(shiny)
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