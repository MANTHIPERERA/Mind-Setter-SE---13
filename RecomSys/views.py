from flask import Blueprint, render_template #flask is used in this project for intgration
from MovieLens import MovieLens #MovieLens class is used to get the data from the dataset
from surprise import SVD #imports SVD (Singular Value Decomposition) class from surprise module
#SVD is a matrix factorization algorithm that is used to make predictions in collaborative filtering. 

views = Blueprint(__name__,"views") 

@views.route("/ButtonPage/") #route to button page
def Button():
    return render_template("RecomSysTest.html")

def BuildAntiTestSetForUser(userId, trainset): 

    '''
    This function is used to build the anti test set for the user.
    An anti-testset is essentially a set of user-item pairs for which 
    the user has not provided a rating. This is useful in evaluating 
    the performance of a recommendation system by predicting ratings 
    for these user-item pairs and comparing them to the true ratings
    '''

    fill = trainset.global_mean #Sets the default rating to the global mean rating of the training set.

    anti_testset = []
    
    u = trainset.to_inner_uid(str(userId))
    
    user_items = set([j for (j, _) in trainset.ur[u]]) 
    '''
    ↑ Gets the set of items that the user has rated in the training set by 
    iterating over the user ratings (ur) for the given user u.
    '''
    anti_testset += [(trainset.to_raw_uid(u), trainset.to_raw_iid(i), fill) for
                             i in trainset.all_items() if
                             i not in user_items]
    
    '''
    ↑ anti_testset += [(trainset.to_raw_uid(u), trainset.to_raw_iid(i), fill)
    for i in trainset.all_items() if i not in user_items]: Iterates over all 
    the items in the training set using trainset.all_items(). For each item i,
    if it is not in the set of items that the user has rated (user_items), 
    the user ID (trainset.to_raw_uid(u)), item ID (trainset.to_raw_iid(i)), 
    and default rating (fill) are added to the anti_testset.
    '''
    return anti_testset



@views.route("/recommendations/<userId>",methods=["GET"]) #flask route added to handle GET requests and calls the home function with the userId as a parameter
def home(userId):
    # Pick an arbitrary test subject

    ml = MovieLens()
    print(f"Getting recommendations for userId: {userId}")    
    print("Loading movie ratings...")
    data = ml.loadMovieLensLatestSmall() #Loads the dataset
    userId = int(userId)

    userRatings = ml.getUserRatings(userId) #get the ratings of the user (Algorithm used can be found in MovieLens.py)
    loved = []
    hated = []
    for ratings in userRatings: #Iterates over the ratings of the user
        if (float(ratings[1]) > 4.0): #If the rating is greater than 4.0, the movie is added to the loved list
            loved.append(ratings)
        if (float(ratings[1]) < 3.0): #If the rating is less than 3.0, the movie is added to the hated list
            hated.append(ratings)

    print("\nUser ", userId, " loved these movies:") #Prints the movies that the user loved and hated
    for ratings in loved:
        print(ml.getMovieName(ratings[0]))
    print("\n...and didn't like these movies:")
    for ratings in hated:
        print(ml.getMovieName(ratings[0]))

    print("\nBuilding recommendation model...")
    trainSet = data.build_full_trainset() #Builds the training set fro recommendation

    algo = SVD()
    algo.fit(trainSet) #trains algorithms on the trainset

    print("Computing recommendations...")
    print("TRAINSET: ",trainSet)
    print("USERID: ",userId)
    testSet = BuildAntiTestSetForUser(userId, trainSet) #Builds the anti test set for the user
    predictions = algo.test(testSet)  #Uses the anti test set to make predictions

    recommendations = []

    print ("\nWe recommend:")
    for userID, movieID, actualRating, estimatedRating, _ in predictions:
        intMovieID = int(movieID)
        recommendations.append((intMovieID, estimatedRating))

    recommendations.sort(key=lambda x: x[1], reverse=True) 

    recommended_movies = [ml.getMovieName(ratings[0]) for ratings in recommendations[:10]]

    return render_template("recommendations.html", recommended_movies=recommended_movies)
