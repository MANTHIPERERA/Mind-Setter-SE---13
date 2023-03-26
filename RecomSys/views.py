from flask import Blueprint, render_template
from MovieLens import MovieLens
from surprise import SVD

views = Blueprint(__name__,"views")

@views.route("/ButtonPage/")
def Button():
    return render_template("RecomSysTest.html")




def BuildAntiTestSetForUser(userId, trainset):
    fill = trainset.global_mean

    anti_testset = []
    
    u = trainset.to_inner_uid(str(userId))
    
    user_items = set([j for (j, _) in trainset.ur[u]])
    anti_testset += [(trainset.to_raw_uid(u), trainset.to_raw_iid(i), fill) for
                             i in trainset.all_items() if
                             i not in user_items]
    return anti_testset

@views.route("/recommendations/<userId>",methods=["GET"])
def home(userId):
    # Pick an arbitrary test subject

    ml = MovieLens()
    print(f"Getting recommendations for userId: {userId}")    
    print("Loading movie ratings...")
    data = ml.loadMovieLensLatestSmall()
    userId = int(userId)

    userRatings = ml.getUserRatings(userId)
    loved = []
    hated = []
    for ratings in userRatings:
        if (float(ratings[1]) > 4.0):
            loved.append(ratings)
        if (float(ratings[1]) < 3.0):
            hated.append(ratings)

    print("\nUser ", userId, " loved these movies:")
    for ratings in loved:
        print(ml.getMovieName(ratings[0]))
    print("\n...and didn't like these movies:")
    for ratings in hated:
        print(ml.getMovieName(ratings[0]))

    print("\nBuilding recommendation model...")
    trainSet = data.build_full_trainset()

    algo = SVD()
    algo.fit(trainSet)

    print("Computing recommendations...")
    print("TRAINSET: ",trainSet)
    print("USERID: ",userId)
    testSet = BuildAntiTestSetForUser(userId, trainSet)
    predictions = algo.test(testSet)

    recommendations = []

    print ("\nWe recommend:")
    for userID, movieID, actualRating, estimatedRating, _ in predictions:
        intMovieID = int(movieID)
        recommendations.append((intMovieID, estimatedRating))

    recommendations.sort(key=lambda x: x[1], reverse=True)

    recommended_movies = [ml.getMovieName(ratings[0]) for ratings in recommendations[:10]]

    return render_template("recommendations.html", recommended_movies=recommended_movies)
