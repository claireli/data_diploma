#LOAD DATA
GRADUATION_WITH_CENSUS_cleansed<-read.csv("GRADUATION_WITH_CENSUS_cleansed.csv")
RATES<-subset(GRADUATION_WITH_CENSUS_cleansed, select=c(grep("RATE_1112", colnames(GRADUATION_WITH_CENSUS_cleansed), perl=TRUE)))
g<-GRADUATION_WITH_CENSUS_cleansed[,c(3,5:25,40:581)]
# REMOVE MOE
g<-subset(g, select=-c(grep("MOE", colnames(g), perl=TRUE)))
#factor shit
g$STNAM<-as.factor(g$STNAM)
g$leanm11<-as.factor(g$leanm11)
# FORMULAS
COHORT_PCT<-function(COHORT, COHORT_TOTAL)
  COHORT_PCT<-COHORT/COHORT_TOTAL
return(COHORT_PCT)
#MAM
MAM_PCT<-COHORT_PCT(g$MAM_COHORT_1112, g$ALL_COHORT_1112)
#MAS
MAS_PCT<-COHORT_PCT(g$MAS_COHORT_1112, g$ALL_COHORT_1112)
#MBL
MBL_PCT<-COHORT_PCT(g$MBL_COHORT_1112, g$ALL_COHORT_1112)
#MHI
MHI_PCT<-COHORT_PCT(g$MHI_COHORT_1112, g$ALL_COHORT_1112)
#MTR
MTR_PCT<-COHORT_PCT(g$MTR_COHORT_1112, g$ALL_COHORT_1112)
#MWH
MWH_PCT<-COHORT_PCT(g$MWH_COHORT_1112, g$ALL_COHORT_1112)
#CWD
CWD_PCT<-COHORT_PCT(g$CWD_COHORT_1112, g$ALL_COHORT_1112)
#ECD
ECD_PCT<-COHORT_PCT(g$ECD_COHORT_1112, g$ALL_COHORT_1112)
#LEP
LEP_PCT<-COHORT_PCT(g$LEP_COHORT_1112, g$ALL_COHORT_1112)

grad<-g[ , c(1:22)]

census<-g[, c(1,2,4,6,8,10,12,14,16,18,20,22:341)]
grad<-cbind(g, data.frame(cbind(MAM_PCT, MAS_PCT, MBL_PCT, MHI_PCT, MTR_PCT, MWH_PCT, CWD_PCT, ECD_PCT, LEP_PCT)))

num_grad<-grad[ , sapply(grad, is.numeric)]
num_census<-census[ , sapply(census, is.numeric)]

weights <- information.gain(ALL_RATE_1112 ~. , num_census)
weights <- information.gain(ALL_RATE_1112 ~. , num_grad)
fit<-lm(num_grad$ALL_RATE_1112 ~ num_grad$MWH_RATE_1112 + num_grad$ECD_RATE_1112, data = num_grad)
