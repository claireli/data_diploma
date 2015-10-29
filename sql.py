import pandas as pd
import sqlalchemy as alc
import petl as etl
__author__ = 'Meraz'
dw_config = {
    "user": "root",
    "password": "claire",
    "host": "localhost",
    "database": 'diploma'
    }
eng = alc.create_engine('mysql+pymysql://{user}:{password}@{host}/{database}'.format(**dw_config), echo=True)
grad = pd.read_csv("GRADUATION_WITH_CENSUS_cleansed.csv")
table = etl.fromdataframe(grad)
print table
grad.to_sql('grad', eng)

