import os #allows run commands in python scripts
import csv #(comma seperated values), imports functionality to read csv files
import sys #imports sys module to, later used with sys.argv 
import re #imports re module to use regular expressions

from surprise import Dataset   #imports Dataset class from surprise module
from surprise import Reader    #imports Reader class from surprise module
from surprise import accuracy
from surprise.model_selection import train_test_split
from surprise import SVD #imports SVD (Singular Value Decomposition) class from surprise module



from collections import defaultdict #imports defaultdict class from collections module
import numpy as np            #imports numpy module (Numeric computing)



class MovieLens: #creates class MovieLens
    

    movieID_to_name = {}  #creates dictionary movieID_to_name
    name_to_movieID = {}  #creates dictionary name_to_movieID
    ratingsPath = '../ml-latest-small/ratings.csv' #creates variable with relative path named ratingsPath to access the ratings.csv file
    moviesPath = '../ml-latest-small/movies.csv'  #creates variable with relative path named moviesPath to access the movies.csv file


    
    def loadMovieLensLatestSmall(self): #creates function loadMovieLensLatestSmall

        # Look for files relative to the directory we are running from
        os.chdir(os.path.dirname(sys.argv[0]))

        ratingsDataset = 0 #creates variable ratingsDataset and sets it to 0
        self.movieID_to_name = {}  #creates dictionary movieID_to_name as an instance variable
        self.name_to_movieID = {}  #creates dictionary name_to_movieID as an instance variable

        reader = Reader(line_format='user item rating timestamp', sep=',', skip_lines=1) 
        #creates variable reader and sets it to Reader class with line_format as mentioned above that splits data with ',' and skip_lines is set to skip line 1 parameters

        ratingsDataset = Dataset.load_from_file(self.ratingsPath, reader=reader)

        # Split the dataset into training and testing sets
        trainset, testset = train_test_split(ratingsDataset, test_size=0.2)

        # Train the model on the training set
        algo = SVD()
        algo.fit(trainset)

        # Make predictions on the testing set
        predictions = algo.test(testset)

        # Evaluate the predictions
        rmse = accuracy.rmse(predictions)
        mae = accuracy.mae(predictions)

        varience = np.var([pred.est for pred in predictions])
        print('Variance:', varience)

        print('RMSE:', rmse)
        print('MAE:', mae)

        with open(self.moviesPath, newline='', encoding='ISO-8859-1') as csvfile: #opens movies.csv file
                movieReader = csv.reader(csvfile) #Reads csv file and return an iterator object
                next(movieReader)  #Skip header line
                for row in movieReader:
                    movieID = int(row[0])
                    movieName = row[1]
                    self.movieID_to_name[movieID] = movieName #adds movieID and movieName to movieID_to_name dictionary
                    self.name_to_movieID[movieName] = movieID #adds movieName and movieID to name_to_movieID dictionary

        return ratingsDataset 

    def getUserRatings(self, user): 
        #gets a user and returns a list of tuples with movieID and rating corresponding to that user
        userRatings = [] #creates empty list userRatings
        hitUser = False #creates variable hitUser and sets it to False
        with open(self.ratingsPath, newline='') as csvfile:
            ratingReader = csv.reader(csvfile)
            next(ratingReader)
            for row in ratingReader:
                userID = int(row[0])
                if (user == userID):
                    movieID = int(row[1])
                    rating = float(row[2])
                    userRatings.append((movieID, rating))
                    hitUser = True
                if (hitUser and (user != userID)):
                    break

        return userRatings #returns list with user ratings

    def getPopularityRanks(self):  #Calculates the popularity of each movie and returns a dictionary with movieID and rank
        ratings = defaultdict(int)
        rankings = defaultdict(int)
        with open(self.ratingsPath, newline='') as csvfile:
            ratingReader = csv.reader(csvfile)
            next(ratingReader)
            for row in ratingReader:
                movieID = int(row[1])
                ratings[movieID] += 1
        rank = 1
        for movieID, ratingCount in sorted(ratings.items(), key=lambda x: x[1], reverse=True):  #extracts the second element of each tuple
            rankings[movieID] = rank
            rank += 1
        return rankings
    
    def getGenres(self):
        genres = defaultdict(list) #creates a dictionary with default value as a list
        genreIDs = {} #creates a dictionary to store genreIDs
        maxGenreID = 0
        with open(self.moviesPath, newline='', encoding='ISO-8859-1') as csvfile:
            movieReader = csv.reader(csvfile)
            next(movieReader)  #Skip header line
            for row in movieReader:
                movieID = int(row[0])
                genreList = row[2].split('|') #creates list with assosiacted geners for each movie
                genreIDList = []
                for genre in genreList:
                    if genre in genreIDs:
                        genreID = genreIDs[genre]
                    else:
                        genreID = maxGenreID
                        genreIDs[genre] = genreID
                        maxGenreID += 1
                    genreIDList.append(genreID)
                genres[movieID] = genreIDList
        # Convert integer-encoded genre lists to bitfields that we can treat as vectors
        for (movieID, genreIDList) in genres.items():
            bitfield = [0] * maxGenreID
            for genreID in genreIDList:
                bitfield[genreID] = 1
            genres[movieID] = bitfield            
        
        return genres
    
    def getYears(self):  #Function not used in this project, although, it gets the year of release of each movie
        p = re.compile(r"(?:\((\d{4})\))?\s*$")
        years = defaultdict(int)
        with open(self.moviesPath, newline='', encoding='ISO-8859-1') as csvfile:
            movieReader = csv.reader(csvfile)
            next(movieReader)
            for row in movieReader:
                movieID = int(row[0])
                title = row[1]
                m = p.search(title)
                year = m.group(1)
                if year:
                    years[movieID] = int(year)
        return years
    
    def getMiseEnScene(self): #this function gets the Mise en Scene features of each movie
        mes = defaultdict(list)
        with open("LLVisualFeatures13K_Log.csv", newline='') as csvfile:
            mesReader = csv.reader(csvfile)
            next(mesReader)
            for row in mesReader:
                movieID = int(row[0])
                avgShotLength = float(row[1])
                meanColorVariance = float(row[2])
                stddevColorVariance = float(row[3])
                meanMotion = float(row[4])
                stddevMotion = float(row[5])
                meanLightingKey = float(row[6])
                numShots = float(row[7])
                mes[movieID] = [avgShotLength, meanColorVariance, stddevColorVariance,
                   meanMotion, stddevMotion, meanLightingKey, numShots]
        return mes
    
    def getMovieName(self, movieID): #gets movieID and returns movieName
        if movieID in self.movieID_to_name:
            return self.movieID_to_name[movieID]
        else:
            return ""
        
    def getMovieID(self, movieName): #gets movieName and returns movieID
        if movieName in self.name_to_movieID:
            return self.name_to_movieID[movieName]
        else:
            return 0