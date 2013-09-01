## Updating Your Fork

The latest and greatest source can be found on [GitHub](https://github.com/GrahamCampbell/Laravel-Binput).  
Before submitting a pull request, you should ensure that your fork is up to date.  

You may fork Laravel Binput:  

    git remote add upstream git://github.com/GrahamCampbell/Laravel-Binput.git

The first command is only necessary the first time. If you have issues merging, you will need to get a merge tool such as [P4Merge](http://perforce.com/product/components/perforce_visual_merge_and_diff_tools).  

You can then update the branch:  

    git pull --rebase upstream develop
    git push --force origin <branch_name>

Once it is set up, run `git mergetool`. Once all conflicts are fixed, run `git rebase --continue`, and `git push --force origin <branch_name>`.  


## Pull Requests

Please submit pull requests against my develop branch.  
  * I will never accept pull requests into the master branch.  
  * If you plan to fix a bug, please create a branch called `fix-`, followed by an appropriate name.  
  * If you plan to add a feature, please create a branch called `feature-`, followed by an appropriate name.  
  * Please indent with 4 spaces rather than tabs, and make sure your code is commented.  
