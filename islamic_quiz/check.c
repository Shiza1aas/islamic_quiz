#include<stdio.h>

int main()
{
	int *p = malloc (sizeof(*p)*(100000*100000));
	int i=0,j=0;

	for ( i = 0 ; i < n ; i++ )
	{
		for( j = 0 ; j < m ; j++ )
		{
			*(p+(i*100000)+j) = 0 ;
		}
	}


    int **a = (int **) malloc(sizeof(int)n);
    int i=0,j=0;
    for(i=0; i<n; i++)
    /* Allocate array, store pointer  */
        a[i] = (int *) malloc(sizeof(int)*m); 

       for(i=0; i<n; i++){
           for(j=0; j<m; j++){
               scanf("%lf",&mat[i][j]);
           }
       }
	
}