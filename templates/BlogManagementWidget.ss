<ul>
	<% if CreatePostLink %><li>
        <a href="$CreatePostLink">
            <%t BlogFrontEnd.CreateNewBlogPost 'Create New Blog Post' %>
        </a>
    </li><% end_if %> 
    
    <% if EditPostLink %><li>
        <a href="$EditPostLink">
            <%t BlogFrontEnd.EditBlogPost 'Edit Blog Post' %>
        </a>
    </li><% end_if %> 
	
    <% if CommentLink %><li>
        <a href="$CommentLink">$CommentText</a>
    </li><% end_if %>
	
    <li>
        <a href="Security/logout"><%t BlogFrontEnd.Logout 'Logout' %></a>
    </li>
</ul>
